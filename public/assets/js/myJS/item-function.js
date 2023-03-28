$(document).ready(() => {
    // function =======================================================
    // formater number function
    $("#content-form-item .keyup-number").on("keyup", function () {
        var type = $(this).data("type");
        var elemen_target = $(this).data("elemen");
        var value = $(this).val();
        var result = "";

        if (isNaN(value) || Number(value) < 1 || value == "") {
            value = 0;
        }

        if (type == "price") {
            result = "Rp. " + formater_number(String(value));
        }

        if (type == "weight") {
            if (Number(value) >= 1000) {
                result = formater_number(String(Number(value) / 1000)) + " Kg";
            } else {
                result = formater_number(String(value)) + " Gr";
            }
        }

        if (type == "number") {
            result = formater_number(String(value));
        }

        $(`#content-form-item ${elemen_target}`).html(result);
    });

    // add current stock
    $("#content-form-item .add-to-current-stock").on("keyup", function () {
        var elemen_target = $(this).data("elemen");
        var current_stock_value = $("#content-form-item #static-stock").val();
        var value = $(this).val();

        if (isNaN(value) || Number(value) < 0) {
            value = 0;
        }

        var result = Number(current_stock_value) + Number(value);
        $("#content-form-item #stock").val(result);
        $("#content-form-item #show-stock").html(
            formater_number(String(result))
        );

        console.log(result);
    });

    // generate slug function
    $("#content-form-item .action-generate-slug").submit(() => {
        var data_ajax = {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: base_url("admin/items/generateSlug"),
            data: { name: $("#content-form-item #name").val() },
            type: "POST",
        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                $("#content-form-item #slug").val(response.response);
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log(jqXHR);
            });

        return false;
    });

    function set_item_data() {
        const photo = $("#content-form-item #photo").prop("files")[0];
        const name = $("#content-form-item #name").val();
        const slug = $("#content-form-item #slug").val();
        const description = $("#content-form-item #description").val();
        const weight = $("#content-form-item #weight").val();
        const stock = $("#content-form-item #stock").val();
        const price = $("#content-form-item #price").val();
        const category = $(
            "option:selected",
            "#content-form-item #category"
        ).val();
        let formData = new FormData();
        formData.append("item_image", photo);
        formData.append("item_name", name);
        formData.append("category_id", category);
        formData.append("slug", slug);
        formData.append("item_description", description);
        formData.append("item_weight", weight);
        formData.append("item_stock", stock);
        formData.append("item_price", price);

        return formData;
    }

    function item_fail(jqXHR) {
        var data_error = jqXHR.responseJSON.response;
        var data_message = jqXHR.responseJSON.message;
        var data_success = jqXHR.responseJSON.success;

        $("#itemModal").modal("hide");
        $("#main-load").removeClass("show");
        alert_show(data_success, data_message);

        $("#content-form-item .form-control").removeClass("is-invalid");
        $("#content-form-item .info").html("");

        if (data_error.item_name) {
            $("#content-form-item #name").addClass("is-invalid");
            $("#content-form-item #infoName").html(
                input_info(false, data_error.item_name)
            );
        }
        if (data_error.category_id) {
            $("#content-form-item #category").addClass("is-invalid");
            $("#content-form-item #infoCategory").html(
                input_info(false, data_error.category_id)
            );
        }
        if (data_error.item_weight) {
            $("#content-form-item #weight").addClass("is-invalid");
            $("#content-form-item #infoWeight").html(
                input_info(false, data_error.item_weight)
            );
        }
        if (data_error.item_stock) {
            $("#content-form-item #stock").addClass("is-invalid");
            $("#content-form-item #infoStock").html(
                input_info(false, data_error.item_stock)
            );
        }
        if (data_error.item_price) {
            $("#content-form-item #price").addClass("is-invalid");
            $("#content-form-item #infoPrice").html(
                input_info(false, data_error.item_price)
            );
        }
        if (data_error.slug) {
            $("#content-form-item #slug").addClass("is-invalid");
            $("#content-form-item #infoSlug").html(
                input_info(false, data_error.slug)
            );
        }
        if (data_error.item_image) {
            $("#content-form-item #photo").addClass("is-invalid");
            $("#content-form-item #infoPhoto").html(
                input_info(false, data_error.item_image)
            );
        }
    }

    // end function  ===================================================

    // add item=========================================================
    $(".action-add-item").on("click", function () {
        var data_ajax = {
            url: base_url("admin/items"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: set_item_data(),
            type: "POST",
        };

        $("#main-load").addClass("show");

        action_rest_file(data_ajax)
            .done((response) => {
                localStorage.setItem("alert_success", JSON.stringify(response));
                window.location.replace(base_url("admin/items"));
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log(jqXHR);
                item_fail(jqXHR);
            });
    });
    // end add item====================================================

    // update item====================================================
    $(".show-update").on("click", () => {
        var btn = `<button type="button" class="action-update-item btn main-btn" style="width: fit-content">Update Data</button>`;
        $("#itemModal #itemModalLabel").html("Update Product Data");
        $("#itemModal modal-body").html(
            "Are you sure you want to update this data"
        );
        $("#itemModal #action-btn").html(btn);

        $(".action-update-item").on("click", () => {
            const static_slug = $("#itemModal #slug").val();
            const slug = $("#content-form-item #slug").val();
            let set_data = set_item_data();
            set_data.append("_method", "PUT");

            var data_ajax = {
                url: base_url("admin/items/" + static_slug),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: set_data,
                type: "POST",
            };

            $("#main-load").addClass("show");

            action_rest_file(data_ajax)
                .done((response) => {
                    localStorage.setItem(
                        "alert_success",
                        JSON.stringify(response)
                    );
                    window.location.replace(
                        base_url(`admin/items/${slug}/edit`)
                    );
                })
                .fail((jqXHR, textStatus, errorThrown) => {
                    console.log(jqXHR);
                    item_fail(jqXHR);
                });
        });
    });

    // end update item ==============================================

    // delete item ==================================================
    $(".show-delete").on("click", () => {
        var btn = `<button type="button" class="action-delete-item btn fail-btn" style="width: fit-content">Delete Data</button>`;
        $("#itemModal #itemModalLabel").html("Delete Product Data");
        $("#itemModal modal-body").html(
            "Are you sure you want to delete this data"
        );
        $("#itemModal #action-btn").html(btn);

        $(".action-delete-item").on("click", function () {
            var static_slug = $("#itemModal #slug").val();

            var data_ajax = {
                url: base_url("admin/items/" + static_slug),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {},
                type: "DELETE",
            };

            $("#main-load").addClass("show");
            action_rest(data_ajax)
                .done((response) => {
                    localStorage.setItem(
                        "alert_success",
                        JSON.stringify(response)
                    );
                    window.location.replace(base_url(`admin/items`));
                })
                .fail((jqXHR, textStatus, errorThrown) => {
                    console.log(jqXHR);
                });
        });
    });

    // end delete item ==============================================
});
