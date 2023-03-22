@extends('mainPart.mainChildBody')

@section('childContent')

            

            <div class="row">
                {{-- value hidden --}}
                    <input type="hidden"  id="list-count-hidden">
                {{-- end value hidden --}}

                <div class="col-lg-7" style="min-height: 20rem;">
                    <div class="row" id="content-list-cart">
                        
                        {{-- list cart on AJAX--}}

                        {{-- end list cart on AJAX--}}

                    </div>
                </div>

                <div class="web col-5 position-relative">
                    <div class="form-cart-content-web">
                        <div class="body shadow">
                            <div class="row">
                                <div class="col-12">
                                    <div class="middle-text fw-bold">
                                        Detail Cart
                                    </div>
                                    <hr class="m-0 mt-1 mb-1">
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 fw-bold">
                                            Cart Count
                                        </div>
                                        <div class="col-8" id="cart-count">
                                            : {{ number_format($carts->count(),0,',','.') }}
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-4 fw-bold">
                                            Total Price
                                        </div>
                                        <div class="col-8" id="total-price">
                                            : Rp. {{ number_format(0,0,',','.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="m-0 mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn main-btn" data-bs-toggle="modal" data-bs-target="#cartModal">Delete All</button>
                                        </div>
                                        <div class="col-6">
                                            <a href="/user/carts/checkout" class="btn success-btn">Pay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mobile row fixed-bottom">
                <div class="col-12">
                    <div class="form-cart-content-mobile">
                        <div class="row">
                            <div class="col-12 pt-3 pb-3 ps-4 pe-4">
                                <div class="row">
                                    <div class="col-4">
                                        Cart Count
                                    </div>
                                    <div class="col-8" id="cart-count">
                                        : {{ number_format($carts->count(),0,',','.') }}
                                    </div>
                                </div>
                              
                                <div class="row">
                                    <div class="col-4">
                                        Total Price
                                    </div>
                                    <div class="col-8" id="total-price">
                                        : Rp. {{ number_format(0,0,',','.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="row">
                                    <div class="col-6 main-background">
                                        <button class="btn bg-transparent main-color-dark" data-bs-toggle="modal" data-bs-target="#cartModal">Delete All</button>
                                    </div>
                                    <div class="col-6 success-background">
                                        <a href="/user/carts/checkout" class="btn bg-transparent success-color-dark">Pay</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 third-background">
                                <a href="/user" class="btn bg-transparent text-start third-color-dark">Go To My Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


{{-- cart modal component --}}

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cartModalLabel">Delete All my Cart</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete all your Cart?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" style="width: fit-content" data-bs-dismiss="modal">Close</button>
        <button type="button" class="action-delete-all-cart btn fail-btn" style="width: fit-content">Delete</button>
      </div>
    </div>
  </div>
</div>
          

{{-- end cart modal component --}}
            
{{-- function javascript --}}

<script>

    $(document).ready(() => {

        render_cart_list();
        action_cart();        
    });

</script>
{{-- end function javascript --}}  
@endsection