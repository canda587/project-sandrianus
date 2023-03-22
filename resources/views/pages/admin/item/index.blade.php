@extends('mainPart.mainChildBody')

@section('childContent')
    
<div class="row" id="pageMyAccount" style="min-height: 20rem;">
    <div class="col-lg-3 mb-3">
        <a href="/admin/items/create" class="btn main-btn"><i class="fa-solid fa-plus me-2"></i> Add Product Data</a>
    </div>
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                                   <div style="font-size: 1.3em;">List Product Data</div>

                                   <div class="dropdown">
                                        <button class="btn bg-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Product Type
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/admin/items">All Product</a></li>
                                            <hr class="m-0">
                                            @foreach ($categories as $category)    
                                                <li><a class="dropdown-item" href="/admin/items?category={{ $category->slug }}">{{ $category->category_name }}</a></li>
                                            @endforeach
                                            <hr class="m-0">
                                            <li><a class="dropdown-item" href="/admin/items?item=out-of-stock">out of stock</a></li>
                                        </ul>
                                    </div>
                               </div>
                    <hr class="m-0 mt-1 mb-1">
                </div>

                <div class="col-12">
                    <div class="list-item-content row">
                        @if ($items->count() > 0)
                           @foreach ($items as $item)    
                            <div class="col-lg-6 mb-5 mb-lg-4">
                                <a href="/admin/items/{{ $item->slug }}/edit">
                                    <div class="body shadow-sm">
                                        
                                        <div class="row">
                                            <div class="col-lg-3 mb-2">
                                                <img src="{{ asset($item->item_image) }}" alt="" style="width: 100%;height: 8rem; object-fit: cover; object-position: 15% 10%;">
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="font-style-2">
                                                            {{ $item->item_name }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row min-text">
                                                    <div class="col-5 col-lg-2">
                                                        Price
                                                    </div>
                                                    <div class="col-7 col-lg-10">
                                                        : Rp. {{ number_format($item->item_price,0,',','.') }}
                                                    </div>
                                                </div>
                                                <div class="row min-text">
                                                    <div class="col-5 col-lg-2">
                                                        Stock
                                                    </div>
                                                    <div class="col-7 col-lg-10">
                                                        : {{ number_format($item->item_stock,0,',','.') }}
                                                    </div>
                                                </div> 
                                            </div>

                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach 
                        @else
                            <div class="col-12">
                                @include('part.item.dataNotFound')
                            </div>
                        @endif
                        
                        
                        
                           
                    </div>
                </div> 
                
                
                <div class="col-12">
                    <div class="d-flex justify-content-center d-lg-block  mt-3 mt-lg-0">
            
                            {{ $items->links() }}
                        
                    </div>
                </div>
            </div>



@endsection