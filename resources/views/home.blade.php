@extends('layouts.app')
@section('content')
        <main class="main">
            <div class="intro-section bg-lighter pt-5 pb-6">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                                <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{
                                        "nav": false, 
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }'>
                                    <div class="intro-slide">
                                        <figure class="slide-image">
                                            <picture>
                                                <source media="(max-width: 480px)" srcset="{{ asset('home/assets/images/slider/slide-1-480w.jpg') }}">
                                                <img src="{{ asset('home/assets/images/slider/slide-1.jpg') }}" alt="Image Desc">
                                            </picture>
                                        </figure><!-- End .slide-image -->

                                        <div class="intro-content">
                                            <h3 class="intro-subtitle">Topsale Collection</h3><!-- End .h3 intro-subtitle -->
                                            <h1 class="intro-title">Monster Hunter<br>Colletion</h1><!-- End .intro-title -->

                                            <a href="category.html" class="btn btn-outline-white">
                                                <span>SHOP NOW</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </a>
                                        </div><!-- End .intro-content -->
                                    </div><!-- End .intro-slide -->

                                    <div class="intro-slide">
                                        <figure class="slide-image">
                                            <picture>
                                                <source media="(max-width: 480px)" srcset="{{ asset('home/assets/images/slider/slide-2-480w.jpg') }}">
                                                <img src="{{ asset('home/assets/images/slider/slide-2.jpg') }}" alt="Image Desc">
                                            </picture>
                                        </figure><!-- End .slide-image -->

                                        <div class="intro-content">
                                            <h3 class="intro-subtitle">News and Inspiration</h3><!-- End .h3 intro-subtitle -->
                                            <h1 class="intro-title">New Arrivals</h1><!-- End .intro-title -->

                                            <a href="category.html" class="btn btn-outline-white">
                                                <span>SHOP NOW</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </a>
                                        </div><!-- End .intro-content -->
                                    </div><!-- End .intro-slide -->

                                    <div class="intro-slide">
                                        <figure class="slide-image">
                                            <picture>
                                                <source media="(max-width: 480px)" srcset="{{ asset('home/assets/images/slider/slide-3-480w.jpg') }}">
                                                <img src="{{ asset('home/assets/images/slider/slide-3.jpg') }}" alt="Image Desc">
                                            </picture>
                                        </figure><!-- End .slide-image -->

                                        <div class="intro-content">
                                            <h3 class="intro-subtitle">Anime Collection</h3><!-- End .h3 intro-subtitle -->
                                            <h1 class="intro-title">Persona and Hololive <br>Collectables</h1><!-- End .intro-title -->

                                            <a href="category.html" class="btn btn-outline-white">
                                                <span>SHOP NOW</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </a>
                                        </div><!-- End .intro-content -->
                                    </div><!-- End .intro-slide -->
                                </div><!-- End .intro-slider owl-carousel owl-simple -->
                                
                                <span class="slider-loader"></span><!-- End .slider-loader -->
                            </div><!-- End .intro-slider-container -->
                        </div><!-- End .col-lg-8 -->
                        <div class="col-lg-4">
                            <div class="intro-banners">
                                <div class="row row-sm">
                                    <div class="col-md-6 col-lg-12">
                                        <div class="banner banner-display">
                                            <a href="#">
                                                <img src="{{ asset('home/assets/images/banners/home/intro/banner-1.jpg') }}" alt="Banner">
                                            </a>

                                            <div class="banner-content">
                                                <h4 class="banner-subtitle text-darkwhite"><a href="#">Clearence</a></h4><!-- End .banner-subtitle -->
                                                <h3 class="banner-title text-white"><a href="#">Chairs & Chaises <br>Up to 40% off</a></h3><!-- End .banner-title -->
                                                <a href="#" class="btn btn-outline-white banner-link">Shop Now<i class="icon-long-arrow-right"></i></a>
                                            </div><!-- End .banner-content -->
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 col-lg-12 -->

                                    <div class="col-md-6 col-lg-12">
                                        <div class="banner banner-display mb-0">
                                            <a href="#">
                                                <img src="{{ asset('home/assets/images/banners/home/intro/banner-2.jpg') }}" alt="Banner">
                                            </a>

                                            <div class="banner-content">
                                                <h4 class="banner-subtitle text-darkwhite"><a href="#">New in</a></h4><!-- End .banner-subtitle -->
                                                <h3 class="banner-title text-white"><a href="#">Best Lighting <br>Collection</a></h3><!-- End .banner-title -->
                                                <a href="#" class="btn btn-outline-white banner-link">Discover Now<i class="icon-long-arrow-right"></i></a>
                                            </div><!-- End .banner-content -->
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 col-lg-12 -->
                                </div><!-- End .row row-sm -->
                            </div><!-- End .intro-banners -->
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->

                    <div class="mb-6"></div><!-- End .mb-6 -->

                    <div class="owl-carousel owl-simple" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": false,
                            "margin": 30,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "420": {
                                    "items":3
                                },
                                "600": {
                                    "items":4
                                },
                                "900": {
                                    "items":5
                                },
                                "1024": {
                                    "items":6
                                }
                            }
                        }'>
                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/1.png') }}" alt="Brand Name">
                        </a>

                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/2.png') }}" alt="Brand Name">
                        </a>

                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/3.png') }}" alt="Brand Name">
                        </a>

                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/4.png') }}" alt="Brand Name">
                        </a>

                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/5.png') }}" alt="Brand Name">
                        </a>

                        <a href="#" class="brand">
                            <img src="{{ asset('home/assets/images/brands/6.png') }}" alt="Brand Name">
                        </a>
                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div><!-- End .bg-lighter -->

            <div class="mb-6"></div><!-- End .mb-6 -->

            <div class="container">
                <div class="heading heading-center mb-3">
                    <h2 class="title-lg">Trendy Products</h2><!-- End .title -->

                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="trendy-all-link" data-toggle="tab" href="#trendy-all-tab" role="tab" aria-controls="trendy-all-tab" aria-selected="true">All</a>
                        </li>
                        @foreach($trendingCategories as $category)
                        <li class="nav-item">
                            <a class="nav-link" id="trendy-{{ $category->id }}-link" data-toggle="tab" href="#trendy-{{ $category->id }}-tab" role="tab" aria-controls="trendy-{{ $category->id }}-tab" aria-selected="false">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- End .heading -->

                <div class="tab-content tab-content-carousel">
                    <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel" aria-labelledby="trendy-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            @foreach($trendyAllProducts as $product)
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    @if($product->discount_percentage > 0)
                                    <span class="product-label label-sale">{{ $product->discount_percentage }}% OFF</span>
                                    @endif
                                    <a href="{{ url('product/'.$product->id) }}">
                                        <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}" class="product-image">
                                        @if(!empty($product->image1))
                                        <img src="{{ asset($product->image1) }}" alt="{{ $product->title }}" class="product-image-hover">
                                        @endif
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title"><a href="{{ url('product/'.$product->id) }}">{{ $product->title }}</a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        @if($product->old_price && $product->old_price > $product->price)
                                        <span class="new-price">₱{{ number_format($product->price, 2) }}</span>
                                        <span class="old-price">Was ₱{{ number_format($product->old_price, 2) }}</span>
                                        @else
                                        ₱{{ number_format($product->price, 2) }}
                                        @endif
                                    </div><!-- End .product-price -->

                                    @if(!empty($product->color))
                                    <div class="product-nav product-nav-dots">
                                        <a href="#" class="active" style="background: {{ $product->color }};"><span class="sr-only">Color name</span></a>
                                    </div><!-- End .product-nav -->
                                    @endif
                                </div><!-- End .product-body -->
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </div><!-- End .product -->
                            @endforeach
                        </div><!-- End .owl-carousel -->
                    </div><!-- .End .tab-pane -->
                    
                    @foreach($trendingCategories as $category)
                    <div class="tab-pane p-0 fade" id="trendy-{{ $category->id }}-tab" role="tabpanel" aria-labelledby="trendy-{{ $category->id }}-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                            data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":4,
                                        "nav": true,
                                        "dots": false
                                    }
                                }
                            }'>
                            @if(isset($trendyCategoryProducts[$category->id]) && count($trendyCategoryProducts[$category->id]) > 0)
                                @foreach($trendyCategoryProducts[$category->id] as $product)
                                <div class="product product-11 text-center">
                                    <figure class="product-media">
                                        @if($product->discount_percentage > 0)
                                        <span class="product-label label-sale">{{ $product->discount_percentage }}% OFF</span>
                                        @endif
                                        <a href="{{ url('product/'.$product->id) }}">
                                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}" class="product-image">
                                            @if(!empty($product->image1))
                                            <img src="{{ asset($product->image1) }}" alt="{{ $product->title }}" class="product-image-hover">
                                            @endif
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                                        </div><!-- End .product-action-vertical -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <h3 class="product-title"><a href="{{ url('product/'.$product->id) }}">{{ $product->title }}</a></h3><!-- End .product-title -->
                                        <div class="product-price">
                                            @if($product->old_price && $product->old_price > $product->price)
                                            <span class="new-price">₱{{ number_format($product->price, 2) }}</span>
                                            <span class="old-price">Was ₱{{ number_format($product->old_price, 2) }}</span>
                                            @else
                                            ₱{{ number_format($product->price, 2) }}
                                            @endif
                                        </div><!-- End .product-price -->

                                        @if(!empty($product->color))
                                        <div class="product-nav product-nav-dots">
                                            <a href="#" class="active" style="background: {{ $product->color }};"><span class="sr-only">Color name</span></a>
                                        </div><!-- End .product-nav -->
                                        @endif
                                    </div><!-- End .product-body -->
                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </div><!-- End .product -->
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <p>No products available in this category.</p>
                                </div>
                            @endif
                        </div><!-- End .owl-carousel -->
                    </div><!-- .End .tab-pane -->
                    @endforeach
                </div><!-- End .tab-content -->
            </div><!-- End .container -->

            <div class="mb-7"></div><!-- End .mb-7 -->

            <div class="container">
                <hr class="mt-3 mb-6">
            	<div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-rocket"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Payment & Delivery</h3><!-- End .icon-box-title -->
                                <p>Free shipping for orders over ₱50</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->

                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-rotate-left"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Return & Refund</h3><!-- End .icon-box-title -->
                                <p>Free 100% money back guarantee</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->

                    <div class="col-lg-4 col-sm-6">
                        <div class="icon-box icon-box-card text-center">
                            <span class="icon-box-icon">
                                <i class="icon-life-ring"></i>
                            </span>
                            <div class="icon-box-content">
                                <h3 class="icon-box-title">Quality Support</h3><!-- End .icon-box-title -->
                                <p>Alway online feedback 24/7</p>
                            </div><!-- End .icon-box-content -->
                        </div><!-- End .icon-box -->
                    </div><!-- End .col-lg-4 col-sm-6 -->
                </div><!-- End .row -->

                <div class="mb-2"></div><!-- End .mb-2 -->
            </div><!-- End .container -->
        </main><!-- End .main -->
@endsection