@extends('mainPart.mainChildBody')

@section('childContent')
<?php 
    $subMenu = "";

    if (isset($_GET['subMenu'])) {
        $subMenu=$_GET['subMenu'];
    }
?>

            <div class="row" id="pageMyAccount">
                <div class="col-12 mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu == "" || $subMenu == "detail")? 'active' : '' }}" aria-current="page" href="/admin/orders/{{ $order->code }}?subMenu=detail"><i class="fa-solid fa-scroll me-2"></i>Detail Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "list")? 'active' : '' }}" href="/admin/orders/{{ $order->code }}?subMenu=list"><i class="fa-solid fa-rectangle-list me-2"></i>List Order</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "pay")? 'active' : '' }}" href="/admin/orders/{{ $order->code }}?subMenu=pay"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Pay Order</a>
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

                <div class="col-12">

                    @if (auth()->user()->is_admin == 0 && $order->status_id == 1)  
                        <div class="row">
                            <div class="offset-lg-9 col-lg-3">
                                <button class="btn fail-btn">Cancel the order</button>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->is_admin == 1)    
                        <div class="row">
                            <div class="offset-lg-9 col-lg-3">
                                <button class="show-update-order btn main-btn" data-bs-toggle="modal" data-code="{{ $order->code }}" data-status="{{ $order->status_id }}" data-bs-target="#orderModal">Update this Order</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            
{{-- modal component --}}
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="orderModalLabel">Modal title</h1>
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
{{-- end modal component --}}


<script>
    $(document).ready(() => {

        $(".show-update-order").on("click",function(){
            const status = $(this).data("status");
            const code = $(this).data("code");
            var btn = `<button type="button" class="action-update-status btn main-btn" data-code="${code}" data-status="${status}" style="width: fit-content">Update</button>`;

            $("#orderModal #orderModalLabel").html("Update Status");
            $("#orderModal .modal-body").html("Do you want to update the status of this order ?");
            $("#orderModal #action-btn").html(btn);
 
        });

        $("#orderModal").on("click",".action-update-status",function(){
            const code = $(this).data("code");
            var status = Number($(this).data("status"));
            var is_finish = 0;
            status += 1;
            
            if(status == 4){
                is_finish = 1;
            }

            var data_ajax = {
                url:base_url("admin/orders/updateStatus/" + code),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{
                    status:status,
                    is_finish:is_finish,
                    _method:"PUT"
                },
                type:"POST"
            };

            $("#main-load").addClass("show");

            action_rest(data_ajax)
            .done((response) => {
                localStorage.setItem("alert_success",JSON.stringify(response));
                var path = base_url('admin/orders/' + code);
                if(response.is_finish == true){
                    path = base_url('admin/orders');
                }
                
                window.location.replace(path);

            })
            .fail((jqXHR,textStatus,errorThorwn) => {
                console.log(jqXHR);
                var data_message = jqXHR.responseJSON.response;
                var data_success = jqXHR.responseJSON.success;
                $("#orderModal").modal("hide");

                alert_show(data_success,data_message);
            });
        });




    })



</script>



@endsection