@extends('mainPart.mainChildBody')

@section('childContent')
    
<div class="row" id="pageMyAccount">
     <div class="col-lg-3 mb-3">
        <a href="/admin/categories/create" class="btn main-btn"><i class="fa-solid fa-plus me-2"></i> Add Category Data</a>
    </div>
                <div class="col-12">
                    <div style="font-size: 1.3em;">List Category Data</div>
                    
                    <hr class="m-0 mt-1 mb-1">
                </div>

                <div class="col-12" style="min-height: 12rem;">

                    @if ($categories->count() > 0)
                        <div class="list-item-content row">
                        
                            @foreach ($categories as $category)
                                
                                <div class="col-lg-3 mb-5 mb-lg-4">
                                    <a href="/admin/categories/{{ $category->slug }}/edit">
                                        <div class="body shadow-sm">
                                            
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <img src="{{($category->category_image)? asset($category->category_image) : asset("assets/images/img_situs/img1.jpg") }}" alt="" style="width: 100%; height:10rem; object-fit: cover; object-position: 15% 10%;">
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12 ">
                                                            <div class="font-style-2 ps-2 pe-2">
                                                                {{ $category->category_name }}
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                                
                        </div>  
                    @else
                        
                        @include('part.item.dataNotFound')

                    @endif
                    
                </div>   
            </div>



@endsection