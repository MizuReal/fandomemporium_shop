<header class="header">
            <style>
                .dropdown-cart-products .product {
                    padding: 15px 0;
                    border-bottom: 1px solid #ebebeb;
                }
                .product-cart-details .product-title {
                    margin-bottom: 8px;
                }
                .cart-product-info {
                    display: block;
                    margin-top: 6px;
                }
                .product-option-small {
                    display: block;
                    margin-top: 6px;
                    font-size: 12px;
                }
            </style>





            
            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="#" class="logo">
                            <img src="{{ asset('home/assets/images/logo.png') }}">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="{{ Request::is('/') ? 'active' : '' }}">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>

                                <li class="{{ Request::is('category/*') ? 'active' : '' }}">
                                    <a href="javascript:;" class="sf-with-ul">Shop</a>
                                    <div class="megamenu megamenu-md">
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <div class="menu-col">
                                                    <div class="row">
                                                        @if(isset($categories) && count($categories) > 0)
                                                            @foreach($categories as $category)
                                                            <div class="col-md-4" style="margin-bottom: 20px;">
                                                                <div class="menu-title">{{ $category->name }}</div><!-- End .menu-title -->
                                                                <ul>
                                                                    @if(isset($category->limitedProducts) && count($category->limitedProducts) > 0)
                                                                        @foreach($category->limitedProducts as $product)
                                                                            <li><a href="{{ url('product/'.$product->id) }}">{{ $product->name }}</a></li>
                                                                        @endforeach
                                                                        <li><a href="{{ route('product.list', ['category' => $category->id]) }}"><strong>View All</strong></a></li>
                                                                    @else
                                                                        <li><a href="{{ route('product.list', ['category' => $category->id]) }}">No products found</a></li>
                                                                    @endif
                                                                </ul>
                                                            </div><!-- End .col-md-4 -->
                                                            @endforeach
                                                        @else
                                                        <div class="col-md-12">
                                                            <div class="menu-title">No Categories Found</div>
                                                        </div>
                                                        @endif
                                                    </div><!-- End .row -->
                                                </div><!-- End .menu-col -->
                                            </div><!-- End .col-md-12 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu megamenu-md -->
                                </li>

                                <li class="{{ Request::is('product/list') || Request::is('product/*') ? 'active' : '' }}">
                                    <a href="{{ url('product/list') }}">Products</a>
                                </li>

                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                            <form action="{{ route('products.search') }}" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="query" id="q" placeholder="Search products..." required>
                                    <button class="btn" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        
                        @guest
                        <div class="login-link" style="margin-right: 15px;">
                            <a href="#signin-modal" data-toggle="modal" style="font-size: 1.3em; display: flex; align-items: center;">
                                <i class="icon-user" style="font-size: 1.2em; margin-right: 5px;"></i>
                                <span>Login</span>
                            </a>
                        </div>
                        @else
                        <div class="dropdown" style="margin-right: 15px;">
                            <a href="javascript:;" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 1.3em; display: flex; align-items: center;">
                                @if(Auth::user()->profile_picture)
                                <img src="{{ asset(Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px; object-fit: cover;">
                                @else
                                <i class="icon-user" style="font-size: 1.2em; margin-right: 5px;"></i>
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">My Profile</a>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                            </div>
                        </div>
                        @endguest

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">{{ Cart::getTotalQuantity() }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    @if(Cart::isEmpty())
                                        <p class="text-center">Your cart is empty</p>
                                    @else
                                        @foreach(Cart::getContent() as $item)
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a href="{{ route('products.detail', $item->id) }}">{{ $item->name }}</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{ $item->quantity }}</span>
                                                    x ₱{{ number_format($item->price, 2) }}
                                                </span>
                                                
                                                @if(isset($item->attributes['options']))
                                                    @if(isset($item->attributes['options']['color']))
                                                    <div class="product-option-small">
                                                        <strong>Color:</strong> {{ $item->attributes['options']['color'] }}
                                                    </div>
                                                    @endif
                                                    
                                                    @if(isset($item->attributes['options']['size']))
                                                    <div class="product-option-small">
                                                        <strong>Size:</strong> {{ $item->attributes['options']['size'] }}
                                                    </div>
                                                    @endif
                                                @endif
                                            </div><!-- End .product-cart-details -->

                                            <figure class="product-image-container">
                                                <a href="{{ route('products.detail', $item->id) }}" class="product-image">
                                                    @if(isset($item->attributes['image']))
                                                        <img src="{{ asset($item->attributes['image']) }}" alt="{{ $item->name }}">
                                                    @else
                                                        <img src="{{ asset('home/assets/images/products/placeholder.jpg') }}" alt="{{ $item->name }}">
                                                    @endif
                                                </a>
                                            </figure>
                                            <form action="{{ route('cart.remove') }}" method="POST" class="remove-form">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $item->id }}">
                                                <button type="submit" class="btn-remove" title="Remove Product"><i class="icon-close"></i></button>
                                            </form>
                                        </div><!-- End .product -->
                                        @endforeach
                                    @endif
                                </div><!-- End .cart-product -->

                                @if(!Cart::isEmpty())
                                <div class="dropdown-cart-total">
                                    <span>Total</span>
                                    <span class="cart-total-price">₱{{ number_format(Cart::getTotal(), 2) }}</span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('cart.view') }}" class="btn btn-primary">View Cart</a>
                                    @if(auth()->check())
                                        <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
                                    @else
                                        <a href="javascript:void(0)" onclick="$('#signin-modal').modal('show'); $('#signin-tab').tab('show');" class="btn btn-outline-primary-2"><span>Login to Checkout</span><i class="icon-long-arrow-right"></i></a>
                                    @endif
                                </div><!-- End .dropdown-cart-total -->
                                @endif
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
