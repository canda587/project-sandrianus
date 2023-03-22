<div class="p-3" style="background-color: white;">
    <input type="hidden" name="" id="hidden-code" value="{{ $order->code }}">
    <div class="row">
        @cannot('is_admin')
            
        <div class="col-12">
             <div style="font-size: 1.3em;">Payers</div> 
            <hr class="m-0 mt-1 mb-1">
        </div>

        <div class="col-12 mb-3">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit.
             Quidem sunt aliquid culpa hic odio voluptatum labore facere 
             recusandae praesentium fugit saepe error, necessitatibus 
             autem similique earum aliquam et officiis repellendus.
        </div>

        <div class="offset-lg-4 col-lg-4 mb-3">
            <div class="rekening-content text-center">
                <div class="middle-font text-light">100-009-002-002</div>
                <div class="middle-font text-light fw-bold">Bank BRI</div>
            </div>
        </div>
        @endcannot

   
        @php
            if((!$order->proof_payment->payment_image && !$order->proof_payment->is_valid) ){
                $payment_validation = '<span class="badge text-bg-secondary">not yet paid</span>';
            }
            elseif($order->proof_payment->payment_image && $order->proof_payment->is_valid == 3){
                $payment_validation = '<span class="badge text-bg-dark">Waiting</span>';
            }
            elseif($order->proof_payment->payment_image && $order->proof_payment->is_valid == 2){
                $payment_validation = '<span class="badge text-bg-danger">Invalid</span>';
            }
            elseif($order->proof_payment->payment_image && $order->proof_payment->is_valid == 1){
                $payment_validation = '<span class="badge text-bg-success">Valid</span>';
            }    


        @endphp


        <div class="col-12">
            <div style="font-size: 1.3em;">Payers</div> 
            <hr class="m-0 mt-1 mb-4">
            
            <div class="mb-3">
                <label for="" class="form-label">Payment Validation</label>
                {!! $payment_validation !!}

                @if ($order->status_id == 1 && !empty($order->proof_payment->payment_image))
                        @can("is_admin")
                              <div class="form-check mb-2">
                                <input class="show-payment-validation form-check-input" type="radio" name="is_valid" id="no_valid" value="2">
                                <label class="form-check-label" for="no_valid">
                                    Is Not Valid
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="show-payment-validation form-check-input" type="radio" name="is_valid" id="valid" value="1">
                                <label class="form-check-label" for="valid">
                                    Is Valid
                                </label>
                            </div>
                        @endcan
                    @endif


            </div>
            

            <div class="row">
                <div class="col-12 mb-3">
                   
                </div>
                <div class="offset-lg-4 col-lg-4 mb-3">
                    @if ($order->proof_payment->payment_image)
                        <img src="{{ asset($order->proof_payment->payment_image) }}" class="show-pay-image mb-3"  alt="" style="width: 100%" data-bs-toggle="modal" data-bs-target="#showPay">
                    @else
                         <div class="pay-content mb-3">
                            <div class="dark-color position-absolute top-50 start-50 translate-middle text-center">
                                <div style="font-size: 3em;"><i class="fa-solid fa-xmark"></i></div>
                                <div>Belum ada Foto Bukti Pembayaran</div>
                                
                            </div>
                        </div>    
                    @endif
                        
                   
                    @if ($order->proof_payment->is_valid == 2 || !$order->proof_payment->is_valid)
                        
                        

                       @cannot('is_admin')
                            <div class="change-image upload-content btn main-btn miniText text-decoration-none mb-3" style="width:100%;">
                                        <span>Upload Foto</span>
                                        <input type="file" name="fotoBaru" id="photo" class="body" >
                            </div>
                            <div class="info" id="order-image-info"></div>
                        @endcannot     
                    @endif
                    
                    


                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- image show component --}}

<!-- Modal -->
<div class="modal fade" id="showPay" tabindex="-1" aria-labelledby="showPayLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="body-show-pay">
        <img id="pay-image" src="{{ asset("assets/images/img_situs/img1.jpg") }}" alt="" style="width: 100%">
    </div>
    {{--  --}}
  </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="paymentModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
        <div id="action-btn">

        </div>
       
      </div>
    </div>
  </div>
</div>



{{-- end image show component --}}



<script>
    $(document).ready(() => {
        
        $(".change-image").on("change", function(event) {
            const code = $("#hidden-code").val();
            const photo = $("#photo").prop("files")[0];

            var path = URL.createObjectURL(event.target.files[0]);
        
        if((photo.type == "image/png" || photo.type == "image/jpeg" || photo.type == "image/jpg") && photo.size <= 1000000){
            var body = `
                <img class="mb-3" src="${path}" alt="" style="width:100%;object-fit: cover;object-position: 80% 100%;">
                Do you want to upload this proof of payment? make sure this proof of payment is valid and has clear photos
            `;

            var btn = `<button type="button" data-code="${code}" class="action-upload-proof-payment btn main-btn" style="width:fit-content;">Upload</button>`;
            $("#paymentModal #paymentModalLabel").html("Upload Proof Payment");
            $("#paymentModal .modal-body").html(body);
            $("#paymentModal #action-btn").html(btn);
            $("#paymentModal").modal("show");
        }
        else{
            

            alert_show(false,"Upload Image is Fail");
        }

            
        });

     $(".show-payment-validation").on("change", function() {
        const is_valid = $("input[name=is_valid]:checked").val();
      

            var style_valid = "fail-btn";
            var text_is_valid = "Invalid"; 
            if(is_valid == 1){
                text_is_valid = "Valid";
                style_valid = "main-btn";
            }
            
            var body = `Are you sure that this proof of payment is set to be ${text_is_valid}`;
             var btn = `<button type="button" class="action-set-proof-payment btn ${style_valid}" style="width:fit-content;">Set to ${text_is_valid}</button>`;
            $("#paymentModal #paymentModalLabel").html("Set Proof Payment");
            $("#paymentModal .modal-body").html(body);
            $("#paymentModal #action-btn").html(btn);
            $("#paymentModal").modal("show");
      

            
        });

    $("#paymentModal").on("click",".action-set-proof-payment", function(){
        const code = $("#hidden-code").val();
        const is_valid = $("input[name=is_valid]:checked").val();

     

        var data_ajax = {
                url: base_url("admin/orders/setPayment/" + code),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    is_valid:is_valid,
                    _method:"PUT"
                },
                type: "POST"
            };

        console.log(data_ajax);

        action_rest(data_ajax)
            .done((response) => {
                console.log(response);
                localStorage.setItem("alert_success",JSON.stringify(response));
                window.location.replace(base_url(`admin/orders/${code}?subMenu=pay`));
            })
            .fail((jqXHR,textStatus,errorThorwn) => {
                console.log(jqXHR);
            });

            console.log(data_ajax);
    });


    $("#paymentModal").on("click",".action-upload-proof-payment", function(){
        const code = $("#hidden-code").val();
        const photo = $("#photo").prop("files")[0];

        let formData = new FormData();
            formData.append("order_image", photo);
            formData.append("_method", "PUT");

        var data_ajax = {
                url: base_url('user/orders/upload/' + code),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formData,
                type: "POST"
            };

        console.log(data_ajax);

        action_rest_file(data_ajax)
            .done((response) => {
                console.log(response);
                localStorage.setItem("alert_success",JSON.stringify(response));
                window.location.replace(base_url(`user/orders/${code}?subMenu=pay`));
            })
            .fail((jqXHR,textStatus,errorThorwn) => {
                var data_error = jqXHR.responseJSON.response;   
                var data_success = jqXHR.responseJSON.success;   
                var data_message = jqXHR.responseJSON.message;   

                alert_show(data_success,data_message);

                if(data_error.order_image){
                    $("order-image-info").html(input_info(data_success,data_error.order_image))
                }
            });

            console.log(data_ajax);
    });

    
    


      $(".show-pay-image").on("click",function(){
        const pay = $(this).attr("src");

        $("#showPay #pay-image").attr("src",pay);
        
      });

    })


</script>