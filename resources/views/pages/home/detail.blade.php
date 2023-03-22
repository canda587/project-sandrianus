@extends('mainPart.mainBody')
@section('mainContent')
    
<div  style="margin-top: 8rem;"></div>

<div class="container dark-color">
    <div class="row">
       <div class="col-lg-3 mb-5">
           <div class="image-detail-content">
            <img class="shadow" src="{{ asset($item->item_image) }}" alt="" >
           </div>
       </div> 

       <div id="order-content" class="col-lg-7" style="min-height: 25rem;">
            {{-- hidden value --}}
            <input id="hidden-destination" type="hidden" value="{{ $destination }}"> 
            <input id="hidden-origin" type="hidden" value="{{ $origin }}"> 
            <input id="hidden-id" type="hidden" value="{{ $item->id_item }}">
            <input id="hidden-count" type="hidden" value="1">
            <input id="hidden-stock" type="hidden" value="{{ $item->item_stock }}">
            <input id="hidden-price" type="hidden" value="{{ $item->item_price }}">
            <input id="hidden-weight" type="hidden" value="{{ $item->item_weight }}">
            {{-- end hidden value --}}

           <div class="row mb-3">
            <div class="col-12 mb-3 mb-lg-0">
                <div class="font-style-1 large-text">{{ $item->item_name }}</div>
                <hr>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">
                        Kategori
                    </div>
                    
                    <div class="col-8">
                       : <span class="main-color-dark">{{ $item->category->category_name }}</span> 
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold">
                        Harga Produk
                    </div>
                    <div class="col-8">
                        : Rp. {{ number_format($item->item_price,0,',','.') }}
                    </div>
                </div>
    
                <div class="row mb-2">
                    <div class="col-4 fw-bold">
                        Produk Tersedia
                    </div>
                    <div class="col-8">
                        : {{ number_format($item->item_stock,0,',','.') }} <span class="bgs success-bgs min-text ms-3">Ready</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 fw-bold mb-1">
                        Deskripsi Produk
                    </div>
                    <div class="col-8 mb-1">
                        : 
                    </div>
                    <div class="col-12">
                       {!! $item->item_description !!}
                    </div>
                </div>
            </div>

            {{-- order form for mobile --}}
            <div class="col-12">
                <h4>Form Order</h4>
                <hr>
                <div class="row order-detail-content-mobile">
                       <div class="col-12 mb-3">
                           <label for="" class="mb-1">Product Count</label>
                           <div class="d-flex">
                               <div class="my-auto p-0 me-4">
                                   <input type="text" id="count" class="form-control m-0 text-center mb-1" style="width: 6rem;" value="1" disabled>
                               </div>
                               <div class="update-count-product my-auto ms-1 me-1"  type="button" data-type="minus">
                                   <i style="font-size: 2em;" class="fa-solid fa-square-minus"></i>
                               </div>
                               <div class="update-count-product my-auto ms-1 me-1"  type="button" data-type="plus">
                                   <i style="font-size: 2em;" class="fa-solid fa-square-plus"></i>
                               </div>
                           </div>
                           <div class="info" id="infoCount">
                               
                           </div>
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
                                        <span id="show-price" class="input-group-text">Rp. {{ number_format($item->item_price,0,',','.') }}</span>
                                        <input type="text" id="price" class="form-control" value="{{ $item->item_price }}" disabled>
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
                        @auth
                           <div class="row">
                                <div class="offset-lg-6 col-lg-3 mb-3">
                                    <button class="action-add-cart btn main-btn"> <i class="fa-solid fa-cart-plus me-2"></i> Add To Cart</button>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <button class="btn success-btn" data-bs-toggle="modal" data-bs-target="#orderModal"><i class="fa-solid fa-hand-holding-dollar me-2"></i> Order Now</button>
                                </div>
                           </div>  
                        @else
                           <div class="row">
                                <div class="offset-lg-6 col-lg-3 mb-3">
                                    <a href="/auth" class="btn main-btn"> <i class="fa-solid fa-cart-plus me-2"></i> Add To Cart</a>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <a href="/auth" class="btn success-btn"> <i class="fa-solid fa-hand-holding-dollar me-2"></i>Order Now</a>
                                </div>
                           </div>
                        @endauth
                           

                           
                       </div>

                      
                   </div>
            </div>
            {{-- end order form for mobile --}}
           </div>


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
        <button type="button" class="action-add-order btn success-btn" style="width: fit-content">Order</button>
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
        
        action_cart();
        expedition_order();
        single_order();

       


        



        // event
       
       
    });


   


</script>


{{-- end function javascript --}}
@endsection