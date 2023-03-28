function single_order() {
    $(".update-count-product").on("click", function () {
        const type = $(this).data("type");
        const weight = Number($("#order-content #hidden-weight").val());
        const stock = Number($("#order-content #hidden-stock").val());
        const price = Number($("#order-content #hidden-price").val());
        var value = Number($("#order-content #hidden-count").val());

        if (type == "plus") {
            if (value < stock) {
                value += 1;
            }
        } else if (type == "minus") {
            if (value > 1) {
                value -= 1;
            }
        }

        var result_price = value * price;

        // hidden value
        $("#order-content #hidden-count").val(value);

        $("#count").val(value);
        $("#price").val(result_price);
        $("#show-price").html(formater_number(String(result_price), "Rp. "));

        $("select[id=expedition-type]").val("");
        $("select[id=expedition-service]").html("");
        $(".show-price-change").html("Rp. 0");
        $(".price-change").val(0);
    });

    // end event

    $(".action-add-order").on("click", function () {
        const service = $(
            "option:selected",
            "select[id=expedition-service]"
        ).data("service");
        const etd = $("option:selected", "select[id=expedition-service]").data(
            "etd"
        );
        const get_service = `${service} - ${etd}`;

        const count = Number($("#order-content #hidden-count").val());
        const weight = Number($("#order-content #hidden-weight").val());
        var result_weight = count * weight;

        var data_ajax = {
            url: base_url("user/orders"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                item_id: $("#order-content #hidden-id").val(),
                order_price: $("#order-content #hidden-price").val(),
                order_count: $("#count").val(),
                order_sub_total: $("#price").val(),
                order_total: $("#total-price").val(),
                expedition_type: $(
                    "option:selected",
                    "select[id=expedition-type]"
                ).val(),
                expedition_service: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).data("service"),
                estimation: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).data("etd"),
                weight: result_weight,
                cost: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).val(),
                origin: $("#order-content #hidden-origin").val(),
                destination: $("#order-content #hidden-destination").val(),
            },
            type: "POST",
        };

        $("#main-load").addClass("show");
        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                localStorage.setItem("alert_success", JSON.stringify(response));
                window.location.replace(
                    base_url("user/orders/" + response.code)
                );
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                var data_error = jqXHR.responseJSON.response;
                var data_success = jqXHR.responseJSON.success;
                var data_message = jqXHR.responseJSON.message;
                $("#orderModal").modal("hide");
                alert_show(data_success, data_message);

                $("#order-content .form-control").removeClass("is-invalid");
                $("#order-content .info").html("");
                if (data_error.expedition_type) {
                    $("select[id=expedition-type]").addClass("is-invalid");
                    $("#expedition-type-info").html(
                        input_info(data_success, data_error.expedition_type)
                    );
                }
                if (data_error.expedition_service) {
                    $("select[id=expedition-service]").addClass("is-invalid");
                    $("#expedition-service-info").html(
                        input_info(data_success, data_error.expedition_service)
                    );
                }
            });
    });
}

function all_order() {
    $("#orderModal").on("click", ".action-add-all-order", function () {
        var data_ajax = {
            url: base_url("user/orders/addAll"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                order_total: $("#total-price").val(),
                expedition_type: $(
                    "option:selected",
                    "select[id=expedition-type]"
                ).val(),
                expedition_service: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).data("service"),
                estimation: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).data("etd"),
                weight: $("#order-content #hidden-weight").val(),
                cost: $(
                    "option:selected",
                    "select[id=expedition-service]"
                ).val(),
                origin: $("#order-content #hidden-origin").val(),
                destination: $("#order-content #hidden-destination").val(),
            },
            type: "POST",
        };

        $("#main-load").addClass("show");

        action_rest(data_ajax)
            .done((response) => {
                localStorage.setItem("alert_success", JSON.stringify(response));
                window.location.replace(
                    base_url("user/orders/" + response.code)
                );
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                var data_error = jqXHR.responseJSON.response;
                var data_success = jqXHR.responseJSON.success;
                var data_message = jqXHR.responseJSON.message;

                alert_show(data_success, data_message);
                $("#orderModal").modal("hide");

                $(".form-control").removeClass("is-invalid");
                $(".info").html("");

                if (data_error.expedition_type) {
                    $("#expedition-type").addClass("is-invalid");
                    $("#info-expedition-type").html(
                        input_info(data_success, data_error.expedition_type)
                    );
                }

                if (data_error.expedition_service) {
                    $("#expedition-service").addClass("is-invalid");
                    $("#info-expedition-service").html(
                        input_info(data_success, data_error.expedition_type)
                    );
                }
            });
    });
}

function expedition_order() {
    function list_serive_expedition(service) {
        var element = `<option value="">Selected Ekspedition Service</option>`;

        service.forEach(function (s) {
            element += `<option value="${s.cost[0].value}" data-service="${
                s.description
            } (${s.service})" data-etd="${s.cost[0].etd}">
                    ${s.description} (${s.service}) Estimasi ${
                s.cost[0].etd
            } - ${formater_number(String(s.cost[0].value), "Rp. ")}
                    </option>`;
        });

        return element;
    }

    $("select[id=expedition-type]").on("change", function () {
        $("select[id=expedition-service]").html("");
        $(".show-price-change").html("Rp. 0");
        $(".price-change").val(0);

        const count = Number($("#order-content #hidden-count").val());
        const weight = Number($("#order-content #hidden-weight").val());

        if (count) {
            var result_weight = count * weight;
        } else {
            var result_weight = weight;
        }

        var data_ajax = {
            url: base_url("expedition"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                courier: $("option:selected", this).val(),
                origin: $("#order-content #hidden-origin").val(),
                destination: $("#order-content #hidden-destination").val(),
                weight: result_weight,
            },
            type: "POST",
        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                $("select[id=expedition-service]").html(
                    list_serive_expedition(response.response)
                );
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                var data_error = jqXHR.responseJSON.response;
                var data_success = jqXHR.responseJSON.success;
                if (data_error) {
                    $("select[id=expedition-type]").addClass("is-invalid");
                    $("#info-expedition-type").html(
                        input_info(data_success, data_error)
                    );
                }
            });
    });

    $("select[id=expedition-service]").on("change", function () {
        const price = $("#price").val();
        const cost = $("option:selected", this).val();
        const service = $("option:selected", this).data("service");
        const etd = $("option:selected", this).data("etd");

        var result_price = Number(price) + Number(cost);

        console.log(result_price);
        $("#expedition-cost").val(cost);
        $("#show-expedition-cost").html(formater_number(String(cost), "Rp. "));
        $("#total-price").val(result_price);
        $("#show-total-price").html(
            formater_number(String(result_price), "Rp. ")
        );
    });
}
