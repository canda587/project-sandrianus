@extends('mainPart.mainChildBody')

@section('childContent')
<?php 
    $subMenu = "";

    if (isset($_GET['subMenu'])) {
        $subMenu=$_GET['subMenu'];
    }
?>

            <div class="row mb-3" id="pageMyAccount">
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu == "" || $subMenu == "detail")? 'active' : '' }}" aria-current="page" href="/user/transactions/{{ $order->code }}?subMenu=detail"><i class="fa-solid fa-scroll me-2"></i>Detail Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "list")? 'active' : '' }}" href="/user/transactions/{{ $order->code }}?subMenu=list"><i class="fa-solid fa-rectangle-list me-2"></i>My List Order</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "pay")? 'active' : '' }}" href="/user/transactions/{{ $order->code }}?subMenu=pay"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Pay Order</a>
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

            <div class="row">
                <div class="offset-lg-9 col-lg-3">
                    <button class="btn fail-btn" data-bs-toggle="modal" data-bs-target="#transactionModal">Delete Transaction</button>
                </div>
            </div>


            {{-- modal component --}}
            <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="transactionModalLabel">Delete Transaction</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are You Sure Delete this Transaction ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
                    <button type="button" class="action-delete-transaction btn fail-btn" data-code="{{ $order->code }}" style="width: fit-content">Delete</button>
                </div>
                </div>
            </div>
            </div>
            {{-- end modal component --}}
        

<script>

    $(document).ready(() => {

        $(".action-delete-transaction").on("click",function(){
            const code = $(this).data("code");

            var data_ajax = {
                url:base_url("user/transactions/" + code),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:{},
                type:"DELETE"
            };
            $("#main-load").addClass("show");
            action_rest(data_ajax)
            .done((response) => {
                console.log(response);

                if(response.success == true){
                    localStorage.setItem("alert_success",JSON.stringify(response));
                    window.location.replace(base_url("user/transactions"));
                }
            })
            .fail((jqXHR,textStatus,errorThorwn) => {
                console.log(jqXHR);
            })
        })


    })



</script>


@endsection