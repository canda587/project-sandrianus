@extends('mainPart.mainChildBody')

@section('childContent')
<?php 
    $subMenu = "";

    if (isset($_GET['subMenu'])) {
        $subMenu=$_GET['subMenu'];
    }
?>      

            <input type="hidden" id="hidden-code" value="{{ $order->code }}">
            <input type="hidden" id="hidden-status" value="{{ $order->status_id }}">
            <input type="hidden" id="hidden-date" value="{{ $order->updated_at }}">

            @if ($order->status_id == 1)    
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="" class="form-label fw-bold">Remaining Time :</label>
                        <span id="remaining-time" class="d-block d-lg-inline main-color-dark" 
                            data-bs-toggle="popover" 
                            data-bs-title="Payment" 
                            data-bs-placement="top"
                            data-bs-content="before the allotted time expires, you are required to make a payment and upload proof of payment">

                            <span class="mx-1" id="day">00</span>:
                            <span class="mx-1" id="hour">00</span>:
                            <span class="mx-1" id="minut">00</span>:
                            <span class="mx-1" id="second">00</span>

                        </span>
                    </div>
                </div>
            @endif
            
            <div class="row mb-3" id="pageMyAccount">
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu == "" || $subMenu == "detail")? 'active' : '' }}" aria-current="page" href="/user/orders/{{ $order->code }}?subMenu=detail"><i class="fa-solid fa-scroll me-2"></i>Detail Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "list")? 'active' : '' }}" href="/user/orders/{{ $order->code }}?subMenu=list"><i class="fa-solid fa-rectangle-list me-2"></i>My List Order</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "pay")? 'active' : '' }}" href="/user/orders/{{ $order->code }}?subMenu=pay"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Pay Order</a>
                        </li>
                        
                    </ul>

                    <div class="nav-tabs-body">
                            {{-- sub menu --}}

                           
                        @if ($subMenu == "" || $subMenu == "detail")
                            
                            @include('part.spesific.detailOrder')  
                        
                        @elseif($subMenu != "" && $subMenu == "list")
                            @include('part.spesific.listOrder')

                        @elseif($subMenu != "" && $subMenu == "pay")
                             @include('part.spesific.payOrder')

                        @endif
                          
                    </div>
                </div> 
            </div>
        

            @if ($order->status_id == 1)    
            <div class="row">
                <div class="offset-lg-9 col-lg-3">
                    <button class="btn fail-btn" data-bs-toggle="modal" data-bs-target="#orderModal">Cancel Order</button>
                </div>
            </div>
            @endif


            {{-- modal component --}}
            <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="orderModalLabel">Order Cancelled</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are You Sure Cancel this Order ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
                    <button type="button" class="action-cancel-order btn fail-btn" data-code="{{ $order->code }}" style="width: fit-content">Delete</button>
                </div>
                </div>
            </div>
            </div>
            {{-- end modal component --}}


<script>

    $(document).ready(() => {

    function remaining_date(data){
            var is_warning = false;
            var global_now = new Date().getTime();
            var global_gap = data.dateline - global_now;

            var getInterval = setInterval(() => {
            var now = new Date().getTime();
            gap =  data.dateline - now;
            

            if(gap <= 1){
                clearInterval(getInterval);
                var data_ajax = {
                  url:data.url_action,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:{
                        _method:"PUT"
                    },
                    type:"POST"
                };
                $("#main-load").addClass("show");
                action_rest(data_ajax)
                .done((response) => {
                  console.log(response);

                  if(response.success == true && data.url_redirect){
                    if(data.use_alert && data.use_alert == true){
                      var alert = {
                        success: true,
                        response : data.message_timeout
                      };
                      localStorage.setItem("alert_success",JSON.stringify(alert));
                    }
                    window.location.replace(window.location.href);
                  }
                })
                .fail((jqXHR,textStatus,errorThorwn) => {
                  console.log(jqXHR);
                })
            }
            else{
                if(gap <= data.warning_time){
                $("#remaining-time").removeClass("main-color-dark");
                $("#remaining-time").addClass("text-danger");
                    is_warning = true;       
                }
                else{
                $("#remaining-time").removeClass("text-danger");
                $("#remaining-time").addClass("main-color-dark");
                }

                var detik = 1000;
                var menit = detik * 60;
                var jam = menit * 60;
                var hari = jam * 24;
        
                var h = Math.floor(Number(gap) / hari);
                var j = Math.floor((Number(gap) % hari) / jam);
                var m = Math.floor((Number(gap) % jam) / menit);
                var d = Math.floor((Number(gap) % menit) / detik);
        
                document.getElementById("day").innerText = h;
                document.getElementById("hour").innerText = j;
                document.getElementById("minut").innerText = m;
                document.getElementById("second").innerText = d;
            }
            console.log(gap + "- this gap");
            console.log(data.warning_time+ " - warning this");

    }, 1000);

}

        const global_code = $("#hidden-code").val();
        const global_status = $("#hidden-status").val();
        const global_date = $("#hidden-date").val();

    

        if(global_status == 1){

            $("#remaining-time").popover("show");


            var date = new Date(global_date).getTime();
            
            var message_timeout = `Sorry, for orders with code ${global_code} we had to cancel`
            var data_remaining = {
            code:global_code,
            url_action : base_url("user/orders/cancel/" + global_code),
            url_redirect : base_url("user/order"),
            use_alert : true,
            message_timeout: message_timeout,
            dateline : date + ((1*24*60*60) * 1000),
            // dateline : date + ((10*60) * 1000),
            warning_time : ((60*60) * 1000) * 10 
            };

            remaining_date(data_remaining);
        }

        

        $(".action-cancel-order").on("click",function(){
            const code = $(this).data("code");

            console.log(code);


            var data_ajax = {
                url:base_url("user/orders/cancel/" + code),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{
                    _method:"PUT"
                },
                type:"POST"
            };
            $("#main-load").addClass("show");
            action_rest(data_ajax)
            .done((response) => {
                console.log(response);

                if(response.success == true){
                    localStorage.setItem("alert_success",JSON.stringify(response));
                    window.location.replace(base_url("user/orders"));
                }
            })
            .fail((jqXHR,textStatus,errorThorwn) => {
                console.log(jqXHR);
            })
        })


    })


</script>
@endsection