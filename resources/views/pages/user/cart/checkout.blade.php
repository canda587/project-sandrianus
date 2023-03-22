@extends('mainPart.mainBody')
@section('mainContent')
    
<div  style="margin-top: 8rem;"></div>

<div class="container dark-color">
    <div class="row justify-content-center">
        

       <div id="order-content" class="col-lg-7" style="min-height: 25rem;">
            
            
            <div class="col-12 mb-4">
                <h4>List Product</h4>
                <hr>
                @php
                    $weight = 0;
                    $item_price = 0;
                @endphp
                @foreach ($carts as $cart)
                @php
                    $weight += $cart->cart_count * $cart->item->item_weight;
                    $item_price += $cart->cart_count * $cart->item->item_price;
                @endphp    
                <div class="row mb-5 shadow py-3 px-4 rounded-3">
                    <div class="col-4">
                        <img src="{{ asset($cart->item->item_image) }}" alt="" style="width: 100%">
                    </div>

                    <div class="col-8">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="fw-bold">
                                    {{ $cart->item->item_name }}
                                </h5>
                            </div>
                            <div class="col-12">
                                <hr class="mb-1 mt-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-lg-4 fw-bold">Count</div>
                            <div class="col-7 col-lg-8 text-end text-lg-start">{{ number_format($cart->cart_count,0,',','.') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-lg-4 fw-bold">Weight</div>
                            <div class="col-7 col-lg-8 text-end text-lg-start">{{ (($cart->item->item_weight * $cart->cart_count)/1000)." Kg" }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-lg-4 fw-bold">Price</div>
                            <div class="col-7 col-lg-8 text-end text-lg-start">Rp. {{ number_format($cart->item->item_price,0,',','.') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-lg-4 fw-bold">Sub Total</div>
                            <div class="col-7 col-lg-8 text-end text-lg-start">Rp. {{ number_format(($cart->cart_count * $cart->item->item_price),0,',','.') }}</div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
           
            {{-- hidden value --}}
            <input id="hidden-destination" type="hidden" value="{{ $destination }}"> 
            <input id="hidden-origin" type="hidden" value="{{ $origin }}"> 
            <input id="hidden-price" type="hidden" value="{{ $item_price }}">
            <input id="hidden-weight" type="hidden" value="{{ $weight }}">
            {{-- end hidden value --}}

            {{-- order form for mobile --}}
            <div class="col-12 mb-5">
                <h4>Form Order</h4>
                <hr>
                <div class="row order-detail-content-mobile">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Total Count</label>
                        <div>{{ $carts->count() }}</div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Total Weight</label>
                        <div>{{ ($weight/1000) ." Kg" }}</div>
                    </div>


                       <div class="col-12 mb-3">
                           <label for="" class="mb-1">Ekspedition Type</label>
                           <select name="" id="expedition-type" class="form-control mb-1">
                               <option value="">Selected Ekspedition Type</option>
                               <option value="jne">JNE</option>
                               <option value="tiki">TIKI</option>
                               <option value="pos">POS INDONESIA</option>
                           </select>
   
                           <div class="info" id="info-expedition-type"></div>
                       </div>
   
                       <div class="col-12 mb-3">
                           <label for="expedition-service" class="mb-1">Ekspedition Service</label>
                           <select name="" id="expedition-service" class="form-control mb-1"></select>

                           <div class="info" id="info-expedition-service"></div>
                       </div>

                       <div class="offset-lg-3 col-lg-9">

                            <div class="row mb-3">
                                <div class="col-lg-3 my-auto mb-2">Product Price</div>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span id="show-price" class="input-group-text">Rp. {{ number_format($item_price,0,',','.') }}</span>
                                        <input type="text" id="price" class="form-control" value="{{ $item_price }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 my-auto mb-2">Expedition Cost</div>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span id="show-expedition-cost" class="show-price-change input-group-text">Rp. {{ number_format(0,0,',','.') }}</span>
                                        <input type="text" id="expedition-cost"  class="price-change form-control" value="0" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 my-auto mb-2">Total Price</div>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span id="show-total-price" class="show-price-change input-group-text">Rp. {{ number_format(0,0,',','.') }}</span>
                                        <input type="text" id="total-price"  class="price-change form-control" value="0" disabled>
                                    </div>
                                </div>
                            </div>
                       </div>

                       <div class="col-12">
                           <hr>
                           <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <a href="/user/carts" class=" btn secondary-btn"> <i class="fa-solid fa-cart-plus me-2"></i> Back To Cart Menu</a>
                                </div>
                                <div class="offset-lg-5  col-lg-3 mb-3">
                                    <button class="btn success-btn" data-bs-toggle="modal" data-bs-target="#orderModal"><i class="fa-solid fa-hand-holding-dollar me-2"></i> Order Now</button>
                                </div>
                           </div>    
                       </div>

                      
                   </div>
            </div>
            {{-- end order form for mobile --}}

                    {{-- recommendation --}}
                @if (!empty($recommendation) && count($recommendation) > 0)    
                    <div class="row">
                        <div class="col-12">
                            <h4>Recommendation</h4>
                            <hr>
                        </div>
                    </div>
                    {{-- item card  --}}
                    @php
                            $set_item_card = [
                                'mobile_column' => 'col-6',
                                'web_column' => 'col-lg-4',
                                'item_data' => $recommendation
                            ];
                        @endphp
                    @include('part.item.itemCard',$set_item_card)
                    {{-- end item card  --}}
                @endif
                {{-- end recommendation --}}



           </div>


           
       </div>

      
    </div>

</div>


<div style="margin-bottom: 10rem;"></div>

{{-- modal component --}}
<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="orderModalLabel">Order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you want to order?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
        <button type="button" class="action-add-all-order btn success-btn" style="width: fit-content">Order</button>
      </div>
    </div>
  </div>
</div>


{{-- end modal component --}}



{{-- function javascript --}}
<script>
    $(document).ready(() => {
        $("#order-content select[id=expedition-type]").val("");
        $("#order-content #expedition-cost").val(0);
        $("#order-content #total-price").val(0);
        $("#order-content #price").val($("#order-content #hidden-price").val());
        $("#order-content #count").val(1);
        
        
        expedition_order();
        all_order();
        // event
       
       
    });


    
   


</script>


{{-- end function javascript --}}
@endsection