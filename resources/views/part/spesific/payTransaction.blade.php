<div class="p-3" style="background-color: white;">
    
    <div class="row">
        <div class="col-12">
            <div style="font-size: 1.3em;">Payers</div> 
            <hr class="m-0 mt-1 mb-4">
            <div class="row">
                <div class="col-12 mb-3">
                   
                </div>
                <div class="offset-lg-4 col-lg-4 mb-3">
                  
                    <img src="{{ asset($transaction->proof_payment->payment_image) }}" class="show-pay-image"  alt="" style="width: 100%" data-bs-toggle="modal" data-bs-target="#showPay">  
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




{{-- end image show component --}}



<script>
    $(document).ready(() => {
        
      


      $(".show-pay-image").on("click",function(){
        const pay = $(this).attr("src");

        $("#showPay #pay-image").attr("src",pay);
        
      });

    })


</script>