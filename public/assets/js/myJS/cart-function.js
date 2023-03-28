// function ===============================================================
// component cart
function cart_component(data) {
    var component = `
                <div class="col-12 mb-5 mb-lg-3">
                            <div class="list-order-content shadow-sm">
                                
                                <div class="row">
                                    <div class="col-3 mb-2">
                                        <img src="${base_url(
                                            data.item.item_image
                                        )}" alt="" style="width: 100%; height:8rem; object-fit: cover; object-position: 50% 10%;">
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="font-style-2 fs-5">
                                                    ${data.item.item_name}
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 col-lg-4">
                                                Price / Pcs
                                            </div>
                                            <div class="col-7 col-lg-8">
                                                : ${formater_number(
                                                    String(
                                                        data.item.item_price
                                                    ),
                                                    "Rp. "
                                                )}
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-5 col-lg-4">
                                                Sub Total
                                            </div>
                                            <div class="col-7 col-lg-8">
                                                : ${formater_number(
                                                    String(
                                                        Number(
                                                            data.item.item_price
                                                        ) *
                                                            Number(
                                                                data.cart_count
                                                            )
                                                    ),
                                                    "Rp. "
                                                )}
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="col-12">
                                        <hr class="m-0 mt-1 mb-3">
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between my-auto">
                                            <div class="my-auto">
                                                <button class="action-delete-cart btn bg-transparent" style="width: fit-content" data-id="${
                                                    data.id_cart
                                                }">
                                                    <i style="font-size: 1.5em;" class="fa-solid fa-trash "></i>
                                                </button>
                                            </div>
                                            <div class="d-flex my-auto">
                                                <input type="text" class="form-control text-center me-3" id="count" style="width: 6rem;" disabled value="${
                                                    data.cart_count
                                                }">
                                                <div class="my-auto">
                                                    <button class="update-count-cart btn bg-transparent" style="width: fit-content" data-count="${
                                                        data.cart_count
                                                    }" data-id="${
        data.id_cart
    }" data-type="minus">
                                                        <i style="font-size: 2em;" class="fa-solid fa-square-minus"></i>
                                                    </button>
                                                </div>
                                                <div class="my-auto">
                                                    <button class="update-count-cart btn bg-transparent" style="width: fit-content" data-count="${
                                                        data.cart_count
                                                    }" data-id="${
        data.id_cart
    }" data-type="plus">
                                                        <i style="font-size: 2em;" class="fa-solid fa-square-plus"></i>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;

    return component;
}

// render component cart
function render_cart_list() {
    var data_ajax = {
        url: base_url("user/carts/getList"),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {},
        type: "POST",
    };

    action_rest(data_ajax)
        .done((response) => {
            var list_cart = "";
            var total_price = 0;
            response.forEach(function (data) {
                total_price +=
                    Number(data.item.item_price) * Number(data.cart_count);
                list_cart += cart_component(data);
            });

            $(".content-action-cart").removeClass("d-none");
            if (response.length < 1) {
                list_cart = component_not_found();
                $(".content-action-cart").addClass("d-none");
            }

            $("#list-count-hidden").val(response.length);
            $("#content-list-cart").html(list_cart);
            $(".form-cart-content-web #cart-count").html(
                ": " + formater_number(String(response.length))
            );
            $(".form-cart-content-web #total-price").html(
                ": " + formater_number(String(total_price), "Rp. ")
            );

            $(".form-cart-content-mobile #cart-count").html(
                ": " + formater_number(String(response.length))
            );
            $(".form-cart-content-mobile #total-price").html(
                ": " + formater_number(String(total_price), "Rp. ")
            );
        })
        .fail((jqXHR, textStatus, errorThorwn) => {
            console.log(jqXHR);
        });
}

// end function =============================================================

function action_cart() {
    // add to cart function ====================================================

    $(".action-add-cart").on("click", function () {
        var data_ajax = {
            url: base_url("user/carts"),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                cart_count: $("#order-content #hidden-count").val(),
                item_id: $("#order-content #hidden-id").val(),
            },
            type: "POST",
        };

        console.log(data_ajax);
        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                alert_show(response.success, response.response);
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log(jqXHR);
            });
    });
    // end add to cart function ===============================================

    // update count cart function =============================================
    $("#content-list-cart").on("click", ".update-count-cart", function () {
        const type = $(this).data("type");
        const id = $(this).data("id");
        var count = Number($(this).data("count"));
        if (type == "plus") {
            count += 1;
        } else if (type == "minus") {
            count -= 1;
        }

        console.log(count);

        var data_ajax = {
            url: base_url("user/carts/" + id),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                cart_count: count,
            },
            type: "PUT",
        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                render_cart_list();
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                render_cart_list();
            });
    });

    // end update count cart function ==========================================

    // delete cart function ====================================================

    $("#content-list-cart").on("click", ".action-delete-cart", function () {
        const id = $(this).data("id");

        var data_ajax = {
            url: base_url("user/carts/" + id),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {},
            type: "DELETE",
        };

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                render_cart_list();
            })
            .fail((jqXHR, textStatus, errorThorwn) => {
                console.log(jqXHR);
                render_cart_list();
            });
    });

    // end delete cart function ================================================

    // delete all cart function ================================================

    $(".action-delete-all-cart").on("click", function () {
        var list_count = $("#list-count-hidden").val();

        if (Number(list_count) > 0) {
            var data_ajax = {
                url: base_url("user/carts/deleteAll"),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {},
                type: "DELETE",
            };

            action_rest(data_ajax)
                .done((response) => {
                    $("#cartModal").modal("hide");
                    alert_show(response.success, response.response);
                    render_cart_list();
                })
                .fail((jqXHR, textStatus, errorThorwn) => {
                    console.log(jqXHR);
                });
        } else {
            $("#cartModal").modal("hide");
            alert_show(
                false,
                "Cannot delete, because you no longer have a Cart"
            );
        }
    });

    // end delete all cart function ============================================
}
