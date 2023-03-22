@extends('mainPart.mainChildBody')

@section('childContent')


            <div class="row" id="pageMyAccount">
                <div class="col-12 mb-3">
                    <div class="head-order-content border-0 shadow-sm">
                        

                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="fw-bold">
                                    Status Pemesanan
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-wrap order-status-tab">
                                    <a href="/user/orders" class="{{ (!isset($_GET['status'])) ? "active" : "" }} mb-2 ms-2 me-2"><i class="fa-brands fa-shopify me-2"></i>All Order</a>
                                    <a href="/user/orders?status=payment" class="{{ ( isset($_GET['status']) && $_GET['status'] == "payment") ? "active" : "" }} mb-2 ms-2 me-2"><i class="fa-solid fa-hand-holding-dollar me-2"></i>Payment</a>
                                    <a href="/user/orders?status=payment-complete" class="{{ ( isset($_GET['status']) && $_GET['status'] == "payment-complete") ? "active" : "" }} mb-2 ms-2 me-2"><i class="fa-solid fa-money-bill me-2"></i>Payment Complete</a>
                                    <a href="/user/orders?status=order-process" class="{{ ( isset($_GET['status']) && $_GET['status'] == "order-process") ? "active" : "" }} mb-2 ms-2 me-2"><i class="fa-solid fa-rotate-right me-2"></i>Order Process</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="col-12">
                    
                       <div class="row mb-3">
                           <div class="col-12">
                               <div style="font-size: 1.3em;">List Order anda</div>
                               <hr class="m-0 mt-1 mb-1">
                           </div>
                       </div>
                       <div class="row">
                           {{--  --}}

                           @if ($orders->count() > 0)
                               
                                @foreach ($orders as $order)
                                    @php
                                        $item = $order->list_order->first();
                                        $other_item = $order->list_order->skip(1);
                                        $style_badge = "text-bg-secondary";
                                        if($order->status_id == 2){
                                            $style_badge = "text-bg-warning";    
                                        }
                                        elseif($order->status_id == 3){
                                            $style_badge = "text-bg-info";  
                                        }
                                        elseif($order->status_id == 4){
                                            $style_badge = "text-bg-success";  
                                        }
                                        elseif($order->status_id == 5){
                                            $style_badge = "text-bg-danger";  
                                        }

                                        
                                    @endphp
                                    
                                    <div class="col-12 mb-5 mb-lg-3">
                                        <div class="list-order-content shadow-sm">
                                            <div class="row">
                                                <div class="col-lg-5 mb-2">
                                                    <div class="main-color-dark">
                                                        {{ $order->code }} <span class="badge {{ $style_badge }} ms-3">{{ $order->status_order->status_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr class="m-0 mt-1 mb-1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 mb-2">
                                                    <img src="{{ asset($item->item->item_image) }}" alt="" style="width: 100%;">
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="font-style-2 middle-text">
                                                            
                                                                {{ $item->item->item_name}} {{ ($other_item->count() > 0)? "( + ".$other_item->count()." Other Product )" : "" }}
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-5 col-lg-2">
                                                            Price / Pcs
                                                        </div>
                                                        <div class="col-7 col-lg-4">
                                                            : Rp. {{ number_format($item->item->item_price,0,',','.') }}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-5 col-lg-2">
                                                            Order Count
                                                        </div>
                                                        <div class="col-7 col-lg-4">
                                                            : {{ $order->list_order->count() }} Order
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-5 col-lg-2">
                                                            Total Harga
                                                        </div>
                                                        <div class="col-7 col-lg-4">
                                                            :  Rp. {{ number_format($order->order_total,0,',','.') }}
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-12">
                                                    <hr class="m-0 mt-1 mb-3">
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="offset-lg-9 col-lg-3">
                                                            <a href="/user/orders/{{ $order->code }}" class="btn main-btn">show Detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @else

                            <div class="col-12 my-5">
                                @include('part.item.dataNotFound')
                            </div>

                           @endif

                           
                       </div>
                    




                </div>

                
            </div>
        
@endsection
