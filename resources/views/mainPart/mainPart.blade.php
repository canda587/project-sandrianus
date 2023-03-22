<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title }}</title>
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Lobster&family=Stick+No+Bills:wght@600&display=swap" rel="stylesheet"> 

    <!-- css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/myCSS/style.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/myCSS/styleAuth.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/myCSS/styleMain.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/myCSS/styleUser.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/myCSS/styleAdmin.css') }}" rel="stylesheet" >
    <!-- fonsawsome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawsome/css/all.min.css') }}">

    {{-- trix css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/trix/trix.css') }}">

    <!-- javascript -->
     <script src="{{ asset('assets/js/myJS/jquery.js') }}"></script>
     <script src="{{ asset('assets/js/myJS/helper.js') }}"></script>
     <script src="{{ asset('assets/js/trix/trix.js') }}"></script>

     {{-- my-function --}}
        <script src="{{ asset('assets/js/myJS/item-function.js') }}"></script>
        <script src="{{ asset('assets/js/myJS/category-function.js') }}"></script>
        <script src="{{ asset('assets/js/myJS/region-function.js') }}"></script>
        <script src="{{ asset('assets/js/myJS/cart-function.js') }}"></script>
        <script src="{{ asset('assets/js/myJS/order-function.js') }}"></script>

      {{-- end my function --}}
  </head>
  <body>
  <div id="mainAlert" class="alert alert-success alert-dismissible alert-hide" role="alert" style="z-index: 1000000">
      <strong id="textType"></strong> <span id="textContent"></span>
  </div> 

@yield('mainBody')

  @include('part.item.logOut')
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  
   
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

  <script>
    $(document).ready(()=>{
      var is_alert = JSON.parse(localStorage.getItem('alert_success'))

      if(is_alert){
        alert_show(is_alert.success,is_alert.response);
        localStorage.removeItem('alert_success');
      }


    });
  </script>
   

    </body>
</html>

