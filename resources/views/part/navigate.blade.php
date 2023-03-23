
     
 {{-- navigate --}}
 <div class="shadow-sm fixed-top">
 <div class="web head-nav">
     <div class="container d-flex justify-content-end">
         <a href="/#pageRecommendation" class="text-dark"><i class="fa-solid fa-receipt me-2"></i>Recommendation</a>
         <a href="/#pageKategori" class="text-dark"><i class="fa-solid fa-boxes-stacked me-2"></i>Categories</a>
         <a href="/#pageProduct" class="text-dark"><i class="fa-solid fa-box-open me-2"></i>Product</a>
         <a href="/#pageAbout" class="text-dark"><i class="fa-solid fa-circle-info me-2"></i>About us</a>
     </div>
 </div>
 <div style="background-color: white;">
     <ul class="main-nav container nav justify-content-between">
         <div class="my-auto">
             <div class="font-brand large-text  dark-color">
                <div class="web">
                    Commerce
                </div>
                
                <div class="mobile">
                    COM
                </div>
             </div>
         </div>
        

         <div class="my-auto d-flex justify-content-end">
             <a class="web  my-auto" href="/" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="custom-tooltip main-ribbon"
                data-bs-title="Main Page">
                <i class="fa-solid fa-house"></i>
             </a>

             @auth
             @cannot("is_admin")
                 <a href="/user/carts" class=" web my-auto" href="" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip main-ribbon"
                    data-bs-title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>   
             @endcannot
                

              <li class="web nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @can("is_admin")
                            <li><a class="dropdown-item" href="/admin">Dashboard</a></li>
                            <li><a class="dropdown-item" href="/admin/orders">Orders Data</a></li>
                        @endcan

                        @cannot("is_admin")
                            <li><a class="dropdown-item" href="/user">My Account</a></li>
                            <li><a class="dropdown-item" href="/user/orders">My Orders</a></li>
                        @endcannot
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item modal-logout-show" href="#">Logout</a></li>
                    </ul>
                </li>
             @else
                <a class="web my-auto" href="/auth" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="custom-tooltip main-ribbon"
                data-bs-title="Login / Registration">
                <i class="fa-solid fa-right-to-bracket"></i>
                </a>
             @endauth
             <a class="mobile btn" data-bs-toggle="offcanvas" href="#navigateMobile" role="button" aria-controls="navigateMobile">
                <i class="fa-solid fa-bars fa-2x"></i>
            </a>


             
         
         </div>
    </ul> 
 </div>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="navigateMobile" aria-labelledby="navigateMobileLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title font-brand" id="navigateMobileLabel">Commerce {{ Request::segment(1) }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="list-group">
        {{-- home menu --}}
        <a href="/" class="list-group-item list-group-item-action {{ (Request::is('/')) ? 'active-list' : '' }}" aria-current="true">
           <i class="fa-solid fa-house me-2"></i> Home
        </a>

        {{-- end home menu --}}

        @auth
                @can("is_admin")
                 {{-- admin menu  --}}
                <a href="#subMenuAdmin" class="list-group-item list-group-item-action {{ (Request::is('admin*')) ? 'active-list' : '' }}" data-bs-toggle="collapse">
                    <i class="fa-solid fa-user me-2"></i>admin
                </a>
                <div class="collapse list-group sub" id="subMenuAdmin">
                    <a href="/admin" class="list-group-item list-group-item-action {{ (Request::is('admin')) ? 'active-list' : '' }}" aria-current="true">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                    <a href="/admin/orders" class="list-group-item list-group-item-action {{ Request::is('admin/orders*') ? 'active-list' : '' }}"><i class="fa-brands fa-shopify me-2"></i>Orders Data</a>
                    <a href="/admin/items" class="list-group-item list-group-item-action {{ Request::is('admin/items*') ? 'active-list' : '' }}"><i class="fa-solid fa-box-open me-2"></i>Products Data</a> 
                    <a href="/admin/categories" class="list-group-item list-group-item-action {{ (Request::is('admin/categories*')) ? 'active-list' : '' }}"><i class="fa-solid fa-boxes-stacked me-2"></i>Categories Data</a> 
                    <a href="/admin/transactions" class="list-group-item list-group-item-action {{ (Request::is('admin/transactions*')) ? 'active-list' : '' }}""><i class="fa-solid fa-file-invoice me-2"></i>Transactions Data</a> 
                </div>
                {{-- end admin menu --}}  
                @endcan 

                @cannot("is_admin")    
                {{-- user menu  --}}
                <a href="#subMenuUser" class="list-group-item list-group-item-action {{ (Request::is('user*')) ? 'active-list' : '' }}" data-bs-toggle="collapse">
                    <i class="fa-solid fa-user me-2"></i>user
                </a>
                <div class="collapse list-group sub" id="subMenuUser">
                    <a href="/user" class="list-group-item list-group-item-action {{ (Request::is('user')) ? 'active-list' : '' }}"" aria-current="true">
                        <i class="fa-solid fa-address-card me-2"></i> My Account
                    </a>
                    <a href="/user/orders" class="list-group-item list-group-item-action {{ Request::is('user/orders*') ? 'active-list' : '' }}"><i class="fa-brands fa-shopify me-2"></i>My Order</a>
                    <a href="/user/carts" class="list-group-item list-group-item-action {{ Request::is('user/carts*') ? 'active-list' : '' }}"><i class="fa-solid fa-cart-shopping me-2"></i>My Cart</a> 
                    <a href="/user/transactions" class="list-group-item list-group-item-action {{ (Request::is('user/transactions*')) ? 'active-list' : '' }}""><i class="fa-solid fa-money-check-dollar me-2"></i>My Transaction</a> 
                </div>

                {{-- end user menu --}}
                @endcan

                

                {{-- logout menu --}}
                    <a  class="list-group-item list-group-item-action modal-logout-show"><i class="fa-solid fa-right-to-bracket me-2"></i> Logout</a>
                {{-- end logout menu --}}
        @else   
                {{-- login or registration menu --}}
                    <a href="/auth" class="list-group-item list-group-item-action"><i class="fa-solid fa-right-to-bracket me-2"></i> Login / Registration</a>
                {{-- end login login or registration menu --}}
        @endauth

        

        

        
    </div>
  </div>
</div>