<nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="{{ Request::is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="{{ Request::is('category/*') ? 'active' : '' }}">
                        <a href="javascript:;" class="sf-with-ul">Shop</a>
                        <ul>
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ url('category/'.$category->id) }}">{{ $category->name }}</a>
                                        @if(isset($category->limitedProducts) && count($category->limitedProducts) > 0)
                                            <ul>
                                                @foreach($category->limitedProducts as $product)
                                                    <li><a href="{{ url('product/'.$product->id) }}">{{ $product->name }}</a></li>
                                                @endforeach
                                                <li><a href="{{ route('product.list', ['category' => $category->id]) }}"><strong>View All</strong></a></li>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li><a href="#">No Categories Found</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="{{ Request::is('product/list') || Request::is('product/*') ? 'active' : '' }}">
                        <a href="{{ url('product/list') }}">Products</a>
                    </li>
                    @auth
                    <li>
                        <a href="javascript:;" class="sf-with-ul">My Account</a>
                        <ul>
                            <li><a href="{{ route('dashboard') }}">My Profile</a></li>
                            <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                            <li><a href="{{ route('user.logout') }}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <li>
                        <a href="#signin-modal" data-toggle="modal">Login</a>
                    </li>
                    @endauth
                </ul>
            </nav><!-- End .mobile-nav -->
