// function base url
function base_url(path = "") {

    return 'http://127.0.0.1:8000/' + path;

}


// end function base url

// function input info
function input_info(type = false, text = "") {
    var color_info = 'fail-color-light';
    var icon_info = '<i class="fa-regular fa-circle-xmark me-2"></i>';
    if (type == true) {
        color_info = 'success-color-dark';
        icon_info = '<i class="fa-regular fa-circle-check me-2"></i>'
    }


    return `<small class="${color_info}">${icon_info + text}</small>`;
}
// end input info

// formater number
function formater_number(angka, prefix = "") {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    // return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    return prefix + rupiah;
}

// end formater number



// function alert
function alert_hide() {
    $("#mainAlert").addClass("alert-hide");
    $("#mainAlert").removeClass("alert-show");
}

function alert_show(alert_type, text_content = "", use_time_out = true, timer = 3000) {


    if (alert_type == true) {
        var text_type = "Success";
        $("#mainAlert").addClass("alert-success");
        $("#mainAlert").removeClass("alert-danger");
    }
    else {
        var text_type = "Fail!!!";
        $("#mainAlert").addClass("alert-danger");
        $("#mainAlert").removeClass("alert-success");
    }

    $("#mainAlert #textType").html(text_type);
    $("#mainAlert #textContent").html(text_content);

    $("#mainAlert").removeClass("alert-hide");
    $("#mainAlert").addClass("alert-show");


    if (use_time_out == true) {
        setTimeout(() => {
            alert_hide();
        }, timer);
    }
}
// end function alert



// function upload image
function change_image(elValue, elShow, imgInfo = null) {
    const image = document.querySelector(elValue);
    const imagePreview = document.querySelector(elShow);
    const imageInfo = document.querySelector(imgInfo);
    var ekstensi = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    var pathFile = image.value;
    if (!ekstensi.exec(pathFile)) {
        imageInfo.innerHTML = input_info(false, "must be Image");
        imagePreview.src = base_url("assets/images/img_situs/img3.jpg");
        image.value = "";
        return false;
    } else {
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function (oFREvent) {
            imagePreview.src = oFREvent.target.result;
        };
        imageInfo.innerHTML = "";
    }
}
// end function upload image

// function component not found
function component_not_found() {

    var component = `
        <div class="text-center my-auto">
            <i class="fa-solid fa-triangle-exclamation fs-1 d-block mb-3"></i> 
            <div class="fs-3">
                Data does not exist or is not found
            </div>
        </div>
    `;

    return component;

}


// end function component not found


// function AJAX
function action_rest(data) {
    return (
        $.ajax({
            headers: data.headers,
            url: data.url,
            type: data.type,
            data: data.data,
            dataType: 'JSON',

        })
    );

}

function action_rest_file(data) {
    return (
        $.ajax({
            headers: data.headers,
            url: data.url,
            type: data.type,
            dataType: "JSON",
            data: data.data,
            cache: false,
            processData: false,
            contentType: false,

        })
    );
}
// end function AJAX




