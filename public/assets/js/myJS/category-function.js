$(document).ready(() => {
    // function ===================================================================

    // generate slug function
    $("#content-form-category .action-generate-slug").submit(() => {
        var data_ajax = {
            url: base_url("admin/categories/generateSlug"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                name: $("#content-form-category #name").val(),
            },
            type: "POST",
        };

        console.log(data_ajax);
        action_rest(data_ajax)
            .done((response) => {
                $("#content-form-category #slug").val(response.response);
                console.log(response);
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
            });

        return false;
    });

    // set data function
    function set_category_data() {
        const photo = $("#content-form-category #photo").prop("files")[0];
        const name = $("#content-form-category #name").val();
        const slug = $("#content-form-category #slug").val();

        let formData = new FormData();
        formData.append("category_image", photo);
        formData.append("category_name", name);
        formData.append("slug", slug);

        return formData;
    }

    // fail function
    function category_fail(jqXHR) {
        $("#categoryModal").modal("hide");
        $("#main-load").removeClass("show");
        var data_error = jqXHR.responseJSON.response;
        var data_message = jqXHR.responseJSON.message;
        var is_success = jqXHR.responseJSON.success;

        alert_show(is_success, data_message);
        $("#content-form-category .form-control").removeClass("is-invalid");
        $("#content-form-category .info").html("");

        if (data_error.category_name) {
            $("#content-form-category #name").addClass("is-invalid");
            $("#content-form-category #infoName").html(
                input_info(false, data_error.category_name)
            );
        }
        if (data_error.category_image) {
            // $("#content-form-category #name").addClass("is-invalid");
            $("#content-form-category #infoPhoto").html(
                input_info(false, data_error.category_image)
            );
        }

        if (data_error.slug) {
            $("#content-form-category #slug").addClass("is-invalid");
            $("#content-form-category #infoSlug").html(
                input_info(false, data_error.slug)
            );
        }
    }

    // end function ===============================================================

    // add category===============================================================
    $(".action-add-category").submit(() => {
        const photo = $("#content-form-category #photo").prop("files")[0];
        const name = $("#content-form-category #name").val();
        const slug = $("#content-form-category #slug").val();

        let formData = new FormData();
        formData.append("category_image", photo);
        formData.append("category_name", name);
        formData.append("slug", slug);

        var data_ajax = {
            url: base_url("admin/categories"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: set_category_data(),
            type: "POST",
        };

        $("#main-load").addClass("show");

        action_rest_file(data_ajax)
            .done((response) => {
                console.log(response);
                localStorage.setItem("alert_success", JSON.stringify(response));
                window.location.replace(base_url("admin/categories"));
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                category_fail(jqXHR);
            });
        return false;
    });

    // end add category =========================================================

    // update category==========================================================
    $(".show-category-update").on("click", function () {
        var btn =
            '<button type="button" class="action-update-category btn main-btn" style="width: fit-content">Update</button>';
        $("#categoryModalLabel").html("Update Category Data");
        $(".form-action-category .modal-body").html(
            "Are you sure you want to update this data ?"
        );
        $(".form-action-category #btn-action").html(btn);
        $("#categoryModal").modal("show");

        $(".action-update-category").on("click", () => {
            const static_slug = $(
                ".form-action-category input[name=slug]"
            ).val();
            const slug = $("#content-form-category #slug").val();
            const old_image = $("#content-form-category #old-image").val();

            let set_data = set_category_data();
            set_data.append("old_image", old_image);
            set_data.append("_method", "PUT");

            var data_ajax = {
                url: base_url("admin/categories/" + static_slug),
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
                    console.log(response);
                    localStorage.setItem(
                        "alert_success",
                        JSON.stringify(response)
                    );
                    window.location.replace(
                        base_url(`admin/categories/${slug}/edit`)
                    );
                })
                .fail((jqXHR, textStatus, errorThrown) => {
                    console.log(jqXHR);
                    category_fail(jqXHR);
                });
        });
    });

    // end update category ====================================================

    // delete category =======================================================
    $(".show-category-delete").on("click", function () {
        var btn =
            ' <button type="button" class="action-delete-category btn fail-btn" style="width: fit-content">Delete</button>';
        $("#categoryModalLabel").html("Delete Category Data");
        $(".form-action-category .modal-body").html(
            "Are you sure you want to delete this data ?"
        );
        $(".form-action-category #btn-action").html(btn);
        $("#categoryModal").modal("show");

        $(".action-delete-category").on("click", () => {
            const static_slug = $(
                ".form-action-category input[name=slug]"
            ).val();
            var data_ajax = {
                url: base_url("admin/categories/" + static_slug),
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
                    console.log(response);
                    localStorage.setItem(
                        "alert_success",
                        JSON.stringify(response)
                    );
                    window.location.replace(base_url(`admin/categories`));
                })
                .fail((jqXHR, textStatus, errorThorwn) => {
                    console.log(jqXHR);
                });
        });
    });

    // end delete category ==================================================
});
