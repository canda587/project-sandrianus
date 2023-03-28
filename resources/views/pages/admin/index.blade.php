@extends('mainPart.mainChildBody')

@section('childContent')
<?php 
    $subMenu = "";

    if (isset($_GET['subMenu'])) {
        $subMenu=$_GET['subMenu'];
    }
?>

            <div class="row " id="pageMyAccount">
                <div class="col-12 mb-3">
                    <div class="bk banner-image-user" style="background-image: url({{ asset('assets/images/img_situs/background-auth.jpg') }})">
                        <div class="overlay main-color-light pt-5 pb-5 ps-3 pe-3" style="opacity: 1">

                            <div class="fw-bold strongFont">
                                Selamat Datang User  
                            </div>
                            <div>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Suscipit nobis exercitationem voluptate distinctio ea 
                                natus eveniet, ipsam adipisci vero, id dolores quasi 
                                quidem deserunt autem voluptatum dolorum tempora 
                                necessitatibus aut sit error ab libero? Dolores 
                                libero suscipit officia esse voluptatum tempore 
                                mollitia placeat, accusamus facere modi iste, quasi veritatis alias.
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="col-12 mb-5">
                    <div style="font-size: 1.3em;">Menu</div> 
                    <hr class="m-0 mt-1 mb-5">

                    <div class="row">
                        <div class="col-lg-4 mb-5">
                                        
                            <a href="admin/orders" class="box-menu  shadow">
                                <div class="ribbon success-background shadow-sm">
                                   <i style="font-size: 2.5em;" class="fa-brands fa-shopify"></i>
                                </div>
                                 <div class="row mb-3">
                                     <div class="offset-4 col-8">
                                         <div class="middle-text">
                                             Data Orders
                                         </div>
                                         
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-12">
                                         <hr class="m-0 mb-1 mt-1">
                                     </div>
                                     <div class="col-12 min-text">
                                         <div>
                                             Result Data : {{ number_format($order->count(),0,',','.') }}
                                         </div>
                                         <div>
                                             New Order : {{ number_format($new_order->count(),0,',','.') }}
                                         </div>  
                                     </div>
                                 </div>
                            </a>
                        </div>
                        <div class="col-lg-4 mb-5">
                                        
                            <a href="admin/items" class="box-menu  shadow">
                                <div class="ribbon main-background text-light shadow-sm">
                                    <i style="font-size: 2.5em;" class="fa-solid fa-box-open"></i>
                                </div>
                                 <div class="row mb-3">
                                     <div class="offset-4 col-8">
                                         <div class="middle-text">
                                             Data Products
                                         </div>
                                        
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-12">
                                         <hr class="m-0 mb-1 mt-1">
                                     </div>
                                     <div class="col-12 min-text">
                                         <div>
                                             Result Data : {{ number_format($item->count(),0,',','.') }}
                                         </div>
                                         <div>
                                             out of stock : {{ number_format($item_stock->count(),0,',','.') }}
                                         </div>  
                                     </div>
                                 </div>
                            </a>
                        </div>
                        <div class="col-lg-4 mb-5">
                                        
                            <a href="admin/categories" class="box-menu  shadow">
                                <div class="ribbon second-background shadow-sm " >
                                    <i style="font-size: 2.5em;" class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                 <div class="row mb-3">
                                     <div class="offset-4 col-8">
                                         <div class="middle-text">
                                             Data Categories
                                         </div>
                                         
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-12">
                                         <hr class="m-0 mb-1 mt-1">
                                     </div>
                                     <div class="col-12 min-text">
                                         <div>
                                             Result Data : {{ number_format($category->count(),0,',','.') }}
                                         </div>
                                          
                                     </div>
                                 </div>
                            </a>
                        </div>
                        <div class="col-lg-4 mb-5">
                                        
                            <a href="admin/transactions" class="box-menu  shadow">
                                <div class="ribbon third-background shadow-sm">
                                    <i style="font-size: 2.5em;" class="fa-solid fa-file-invoice"></i>
                                   
                                </div>
                                 <div class="row mb-3">
                                     <div class="offset-4 col-8">
                                         <div class="middle-text">
                                             Data Transaction
                                         </div>
                                        
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-12">
                                         <hr class="m-0 mb-1 mt-1">
                                     </div>
                                     <div class="col-12 min-text">
                                         <div>
                                             Result Data : {{ number_format($transaction->count(),0,',','.') }}
                                         </div>
                                         <div>
                                             Total Income : Rp. {{ number_format($transaction->sum("transaction_total"),0,',','.') }}
                                         </div>
                                          
                                     </div>
                                 </div>
                            </a>
                        </div>
                    </div>
                </div>




                <div class="col-12" id="section-biodata">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu == "" || $subMenu == "biodata")? 'active' : '' }} " aria-current="page" href="/admin?subMenu=biodata#section-biodata"><i class="fa-solid fa-user me-2"></i>My Biodata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "address")? 'active':'' }}" href="/admin?subMenu=address#section-biodata"><i class="fa-solid fa-location-dot me-2"></i>My Address</a>
                        </li>
                        
                    </ul>

                    <div class="nav-tabs-body">
                            {{-- sub content --}}
                                @if ($subMenu == "" || $subMenu == "biodata")
                                    @php
                                        $set_biodata = [
                                            'biodata' => auth()->user()
                                        ];
                                    @endphp 
                                    @include('part.spesific.biodata',$set_biodata)
                                @elseif($subMenu != "" || $subMenu == "address")
                                    @php
                                        $set_address = [
                                            'address' => auth()->user()->region
                                        ];
                                    @endphp
                                    @include('part.spesific.address',$set_address)
                                    
                                @endif
                            {{-- end sub content --}}

                    </div>
                </div>
            </div>
        
@endsection