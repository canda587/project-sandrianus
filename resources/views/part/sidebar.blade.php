<div class="web col-3 position-relative">
            <div class="sidebar">
                <div class="body shadow">
                    <div class="ribbon main-background  shadow-sm">
                        <span class="main-color-light" style="font-size: 1.3em;">Navigate Menu</span>
                       
                    </div>

                    <ul class="list">
                        <li>
                            <a  href="/">
                               <i class="fa-solid fa-house me-2"></i> Go To Main Page
                            </a>
                        </li>

                        @can("is_admin")
                           <li>
                                <a class="{{ (Request::is('admin')) ? 'active' : '' }}" href="/admin" >
                                <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                                </a>
                            </li>     
                        @endcan
                             
                        @cannot("is_admin")
                             <li>
                                <a class="{{ (Request::is('user')) ? 'active' : '' }}"href="/user">
                                <i class="fa-solid fa-address-card me-2"></i> My Account
                                </a>
                            </li>
                        @endcannot
                
                        <hr>
                        @can("is_admin")
                             <li>
                                <a class="{{ (Request::is('admin/orders*')) ? 'active' : '' }}" href="/admin/orders">
                                <i class="fa-brands fa-shopify me-2"></i> Orders Data
                                </a>
                            </li>
                            <li>
                                <a class="{{ (Request::is('admin/items*')) ? 'active' : '' }}" href="/admin/items">
                                <i class="fa-solid fa-box-open me-2"></i> Product Data
                                </a>
                            </li>
                            <li>
                                <a class="{{ (Request::is('admin/categories*')) ? 'active' : '' }}" href="/admin/categories">
                                <i class="fa-solid fa-boxes-stacked me-2"></i> Categories Data
                                </a>
                            </li>
                            <li>
                                <a class="{{ (Request::is('admin/transactions*')) ? 'active' : '' }}" href="/admin/transactions">
                                <i class="fa-solid fa-file-invoice me-2"></i> Transactions Data
                                </a>
                            </li>
                        @endcan

                        
                        @cannot("is_admin")
                            
                            <li>
                                <a class="{{ (Request::is('user/orders*')) ? 'active' : '' }}" href="/user/orders">
                                <i class="fa-brands fa-shopify me-2"></i> My Order
                                </a>
                            </li>
                            <li>
                                <a class="{{ (Request::is('user/carts*')) ? 'active' : '' }}" href="/user/carts">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> My Cart
                                </a>
                            </li>
                            <li>
                                <a class="{{ (Request::is('user/transactions*')) ? 'active' : '' }}" href="/user/transactions">
                                <i class="fa-solid fa-money-check-dollar me-2"></i> My Transaction
                                </a>
                            </li>
                        @endcannot    
                        
                        


                        <hr>
                        <li>
                            <a class="modal-logout-show">
                               <i class="fa-solid fa-power-off me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>