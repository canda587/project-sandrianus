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

                <div class="col-12" >
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu == "" || $subMenu == "biodata")? 'active' : '' }} " aria-current="page" href="/user?subMenu=biodata"><i class="fa-solid fa-user me-2"></i>My Biodata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($subMenu != "" && $subMenu == "address")? 'active':'' }}" href="/user?subMenu=address"><i class="fa-solid fa-location-dot me-2"></i>My Address</a>
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