@extends('mainPart.mainBody')

@section('mainContent')
<?php 
    $subMenu = "";

    if (isset($_GET['subMenu'])) {
        $subMenu=$_GET['subMenu'];
    }
?>

<div class="web"  style="margin-top: 9rem;"></div>
<div class="mobile" style="margin-top: 6rem;"></div>
<div class="container" >
    <div class="row">
        {{-- sidebar --}}
        @include('part.sidebar')
        {{-- end sidebar --}}



        <div class="col-lg-9 colorDis" id="account-body">
            {{-- header --}}
            @include('part.childHeader')
            {{-- end header --}}

            {{-- child content --}}
            @yield('childContent')
            {{-- child content --}}

            
        </div>
    </div>


</div>
<div style="margin-bottom: 8rem;"></div>
@endsection