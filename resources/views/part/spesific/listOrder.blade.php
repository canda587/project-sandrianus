<div class="p-3" style="background-color: white;">
<div class="row mb-3">
                           <div class="col-12">
                               <div style="font-size: 1.3em;">List Order</div>
                               <hr class="m-0 mt-1 mb-1">
                           </div>
                       </div>
                       <div class="row" style="height:30rem; overflow-x: hidden; overflow-y: auto;">
                           @foreach ($order->list_order as $list)
                
                            <div class="col-12 mb-5 mb-lg-3">
                                <div class="list-order-content shadow-sm">
                                    
                                    <div class="row">
                                        <div class="col-lg-3 mb-2">
                                            <img src="{{ asset($list->item->item_image) }}" alt="" style="width: 100%;">
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="font-style-2 middle-text">
                                                        {{ $list->item->item_name }}
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                 
                                             <div class="row">
                                                <div class="col-5 col-lg-2">
                                                    Count
                                                </div>
                                                <div class="col-7 col-lg-4">
                                                    : {{ number_format($list->order_count,0,',','.') }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-5 col-lg-2">
                                                    Price / Pcs
                                                </div>
                                                <div class="col-7 col-lg-4">
                                                    : Rp. {{ number_format($list->order_price,0,',','.') }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-5 col-lg-2">
                                                    Sub Total
                                                </div>
                                                <div class="col-7 col-lg-4">
                                                    : Rp. {{ number_format($list->order_sub_total,0,',','.') }}
                                                </div>
                                            </div>
                                            
                                        </div>

                                        @cannot('is_admin')    
                                            <div class="col-12">
                                                <hr class="m-0 mt-1 mb-3">
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="offset-lg-9 col-lg-3">
                                                        <a href="/detail/{{ $list->item->slug }}" class="btn main-btn">Pay More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcannot
                                    </div>
                                </div>
                            </div>
                            @endforeach
                       </div>


</div>