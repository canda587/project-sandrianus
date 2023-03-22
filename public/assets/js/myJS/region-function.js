$(document).ready(() => {


    function list_province(province, code = null) {

        var element = `<option value="">Select a Provice</option>`;

        province.forEach(function (p) {
            if (code != null && code == p.province_id) {
                element += `<option value="${p.province_id}" selected>${p.province}</option>`;
            }
            else {
                element += `<option value="${p.province_id}">${p.province}</option>`;
            }
        });

        return element
    }

    function list_city(city, code = null) {

        var element = `<option value="">Select a City</option>`;

        city.forEach(function (p) {
            if (code != null && code == p.city_id) {

                element += `<option value="${p.city_id}" selected>${p.city_name}</option>`;
            }
            else {

                element += `<option value="${p.city_id}">${p.city_name}</option>`;
            }
        });

        return element
    }

    function region_fail(jqXHR) {
        var data_error = jqXHR.responseJSON.response;
        var data_success = jqXHR.responseJSON.success;
        var data_message = jqXHR.responseJSON.message;

        alert_show(data_success, data_message);


        $("#regionModal .form-control").removeClass("is-invalid");
        $("#regionModal .info").html("");

        if (data_error.province_code || data_error.province_name) {
            $("#regionModal #province").addClass("is-invalid");
            $("#regionModal #province-info").html(input_info(data_success, data_error.province_code));
        }
        if (data_error.city_code || data_error.city_name) {
            $("#regionModal #city").addClass("is-invalid");
            $("#regionModal #city-info").html(input_info(data_success, data_error.city_code));
        }
        if (data_error.address_detail) {
            $("#regionModal #address-detail").addClass("is-invalid");
            $("#regionModal #address-detail-info").html(input_info(data_success, data_error.address_detail));
        }
    }

    $(".show-add").on("click", () => {

        $("#regionModal #regionModalLabel").html("Add Address");
        var data_ajax = {
            url: base_url("region/allProvince"),
            headers: {},
            data: {},
            type: "GET"
        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                var parent_element = `
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-control" name="province" id="province">
                            ${list_province(response.response)}
                        </select>
                        <div class="info" id="province-info"></div>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select class="form-control" name="city" id="city">
                            <option value="">Select a City</option>
                        </select>
                        <div class="info" id="city-info"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address-detail" class="form-label">Address Detail</label>
                        <textarea class="form-control" id="address-detail" rows="3"></textarea>
                        <div class="info" id="address-detail-info"></div>
                    </div>                
                `;

                var btn = '<button type="button" class="action-add btn main-btn" style="width: fit-content">Add</button>';

                $("#regionModal #action-btn").html(btn);
                $("#regionModal .modal-body").html(parent_element);


            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                var data_error = jqXHR.responseJSON;

                var elemen = `<div class="fs-4 m-5"> ${input_info(data_error.success, data_error.response)} </div>`;

                $("#regionModal .modal-body").html(elemen);
            })


    });



    $(".show-update").on("click", function () {

        $("#regionModal #regionModalLabel").html("Update Address");
        var data_ajax = {
            url: base_url("region/getRegion"),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {},
            type: "POST"

        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                var region = response.response;
                var parent_element = `
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-control" name="province" id="province">
                            ${list_province(region.province, region.province_code)}
                        </select>
                        <div class="info" id="province-info"></div>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select class="form-control" name="city" id="city">
                            ${list_city(region.city, region.city_code)}
                        </select>
                        <div class="info" id="city-info"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address-detail" class="form-label">Address Detail</label>
                        <textarea class="form-control" id="address-detail" rows="3"> ${region.address_detail} </textarea>
                        <div class="info" id="address-detail-info"></div>
                    </div>                
                `;

                var btn = `<button type="button" class="action-update btn main-btn" style="width: fit-content" data-code="${region.region_code}">Update</button>`;

                $("#regionModal #action-btn").html(btn);
                $("#regionModal .modal-body").html(parent_element);


            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
            });
        console.log(data_ajax);


    });


    $("#regionModal").on("change", "select[name=province]", function () {
        var province = $("option:selected", this).val();
        $("#regionModal .modal-body select[name=city]").html("");
        var data_ajax = {
            url: base_url("region/allCity"),
            headers: {},
            data: { province: province },
            type: "GET"
        };

        action_rest(data_ajax)
            .done((response) => {

                $("#regionModal .modal-body select[name=city]").html(list_city(response.response));

            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
            });
    });


    $("#regionModal").on("click", ".action-add", () => {
        var data_ajax = {
            url: base_url("region/store"),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                province_code: $("option:selected", "#regionModal #province").val(),
                city_code: $("option:selected", "#regionModal #city").val(),
                province_name: $("option:selected", "#regionModal #province").text(),
                city_name: $("option:selected", "#regionModal #city").text(),
                address_detail: $("#regionModal #address-detail").val(),
            },
            type: "POST"
        };

        console.log(data_ajax);

        action_rest(data_ajax)
            .done((response) => {
                localStorage.setItem("alert_success", JSON.stringify(response));

                window.location.replace(base_url("user?subMenu=address"));
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                region_fail(jqXHR);

            })
    });


    $("#regionModal").on("click", ".action-update", function () {
        var code = $(this).data("code");
        var data_ajax = {
            url: base_url("region/" + code),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                province_code: $("option:selected", "#regionModal #province").val(),
                city_code: $("option:selected", "#regionModal #city").val(),
                province_name: $("option:selected", "#regionModal #province").text(),
                city_name: $("option:selected", "#regionModal #city").text(),
                address_detail: $("#regionModal #address-detail").val(),
                _method: "PUT"
            },
            type: "POST"
        };

        console.log(data_ajax);

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                localStorage.setItem("alert_success", JSON.stringify(response));
                window.location.replace(base_url("user?subMenu=address"));
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                region_fail(jqXHR);

            })
    });
});