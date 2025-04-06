@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">


<!-- molla/category.html  22 Nov 2019 10:02:48 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fandom Emporium - Products</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Fandom Emporium - Shop for your favorite fandom merchandise">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
</head>

<body>
    <div class="page-wrapper">

        <main class="main">
            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                                        @if(isset($searchTerm))
                                        Showing <span>{{ $products->count() }} of {{ $products->total() }}</span> Search Results for "{{ $searchTerm }}"
                                        @else
                						Showing <span>{{ $products->count() }} of {{ $products->total() }}</span> Products
                                        @endif
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-center">
                                    @forelse($products as $product)
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                @if($product->status === 'out_of_stock')
                                                <span class="product-label label-out">Out of Stock</span>
                                                @endif
                                                <a href="{{ route('products.detail', $product->id) }}">
                                                    @if($product->main_image)
                                                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}" class="product-image">
                                                    @else
                                                    <img src="assets/images/products/placeholder.jpg" alt="Product image" class="product-image">
                                                    @endif
                                                </a>

                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                                </div><!-- End .product-action-vertical -->

                                                <div class="product-action">
                                                    <form id="cart-form-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        @if($product->color)
                                                            <input type="hidden" name="color" value="{{ $product->color }}">
                                                        @endif
                                                        @if($product->size)
                                                            <input type="hidden" name="size" value="{{ $product->size }}">
                                                        @endif
                                                    </form>
                                                    <a href="javascript:void(0);" onclick="document.getElementById('cart-form-{{ $product->id }}').submit();" class="btn-product btn-cart"><span>add to cart</span></a>
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="{{ url('category/'.$product->category_id) }}">{{ $product->category ? $product->category->name : 'Uncategorized' }}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="{{ route('products.detail', $product->id) }}">{{ $product->name }}</a></h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    @if($product->old_price)
                                                    <span class="old-price">₱{{ number_format($product->old_price, 2) }}</span>
                                                    @endif
                                                    ₱{{ number_format($product->new_price, 2) }}
                                                </div><!-- End .product-price -->
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        @php
                                                            // Calculate average rating percentage (5 stars = 100%)
                                                            $avgRating = $product->reviews ? ($product->reviews->avg('rating') / 5) * 100 : 0;
                                                        @endphp
                                                        <div class="ratings-val" style="width: {{ $avgRating }}%;" data-width="{{ $avgRating }}"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                    <span class="ratings-text">( {{ $product->reviews ? $product->reviews->count() : 0 }} {{ Str::plural('Review', $product->reviews ? $product->reviews->count() : 0) }} )</span>
                                                </div><!-- End .rating-container -->
                                                @if($product->color)
                                                <div class="product-nav product-nav-dots">
                                                    <a href="#" style="background: {{ $product->color }};">
                                                        <span class="sr-only">Color name</span>
                                                    </a>
                                                </div><!-- End .product-nav -->
                                                @endif
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-lg-4 -->
                                    @empty
                                    <div class="col-12">
                                        <p class="text-center">No products found</p>
                                    </div>
                                    @endforelse
                                </div><!-- End .row -->
                            </div><!-- End .products -->

                			<nav aria-label="Page navigation">
                                @if(isset($searchTerm))
							    {{ $products->appends(['query' => $searchTerm])->links('vendor.pagination.bootstrap-4') }}
                                @else
							    {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                                @endif
							</nav>
                		</div><!-- End .col-lg-9 -->
                		<aside class="col-lg-3 order-lg-first">
                			<div class="sidebar sidebar-shop">
                				<div class="widget widget-clean">
                					<label>Filters:</label>
                					<a href="javascript:void(0);" class="sidebar-filter-clear" onclick="window.location.replace('{{ route('product.list') }}');">Clear Filters</a>
                				</div><!-- End .widget widget-clean -->

                                <form id="filter-form" action="{{ route('product.list') }}" method="GET">
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                                Category
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-1">
                                            <div class="widget-body">
                                                <div class="filter-items filter-items-count">
                                                    @if(isset($sidebar_categories) && count($sidebar_categories) > 0)
                                                        @foreach($sidebar_categories as $category)
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                                    id="cat-{{ $category->id }}" 
                                                                    name="category" 
                                                                    value="{{ $category->id }}"
                                                                    @if(request()->category == $category->id) checked @endif
                                                                    onchange="document.getElementById('filter-form').submit()">
                                                                <label class="custom-control-label" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                                            </div><!-- End .custom-checkbox -->
                                                            <span class="item-count">{{ \App\Models\ProductModel::where('category_id', $category->id)->count() }}</span>
                                                        </div><!-- End .filter-item -->
                                                        @endforeach
                                                    @else
                                                        @php
                                                            $sidebar_categories = \App\Models\CategoryModel::where('status', 1)->get();
                                                        @endphp
                                                        @foreach($sidebar_categories as $category)
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                                    id="cat-{{ $category->id }}" 
                                                                    name="category" 
                                                                    value="{{ $category->id }}"
                                                                    @if(request()->category == $category->id) checked @endif
                                                                    onchange="document.getElementById('filter-form').submit()">
                                                                <label class="custom-control-label" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                                            </div><!-- End .custom-checkbox -->
                                                            <span class="item-count">{{ \App\Models\ProductModel::where('category_id', $category->id)->count() }}</span>
                                                        </div><!-- End .filter-item -->
                                                        @endforeach
                                                    @endif
                                                </div><!-- End .filter-items -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .widget -->

                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                                Size
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-2">
                                            <div class="widget-body">
                                                <div class="filter-items">
                                                    @php
                                                        $sizes = \App\Models\ProductModel::distinct()->whereNotNull('size')->pluck('size');
                                                    @endphp
                                                    @foreach($sizes as $size)
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                                id="size-{{ $loop->index }}"
                                                                name="size"
                                                                value="{{ $size }}"
                                                                @if(request()->size == $size) checked @endif
                                                                onchange="document.getElementById('filter-form').submit()">
                                                            <label class="custom-control-label" for="size-{{ $loop->index }}">{{ $size }}</label>
                                                        </div><!-- End .custom-checkbox -->
                                                    </div><!-- End .filter-item -->
                                                    @endforeach
                                                </div><!-- End .filter-items -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .widget -->

                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                                Color
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-3">
                                            <div class="widget-body">
                                                <div class="filter-colors">
                                                    @php
                                                        $colors = \App\Models\ProductModel::distinct()->whereNotNull('color')->pluck('color');
                                                    @endphp
                                                    @foreach($colors as $color)
                                                    <a href="{{ route('product.list', ['color' => $color]) }}" 
                                                       style="background: {{ $color }};" 
                                                       @if(request()->color == $color) class="selected" @endif>
                                                       <span class="sr-only">{{ $color }}</span>
                                                    </a>
                                                    @endforeach
                                                </div><!-- End .filter-colors -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .widget -->

                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                                Brand
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-4">
                                            <div class="widget-body">
                                                <div class="filter-items">
                                                    @php
                                                        $brands = \App\Models\ProductModel::distinct()->whereNotNull('brand')->pluck('brand');
                                                    @endphp
                                                    @foreach($brands as $brand)
                                                    <div class="filter-item">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input filter-checkbox" 
                                                                id="brand-{{ $loop->index }}"
                                                                name="brand"
                                                                value="{{ $brand }}"
                                                                @if(request()->brand == $brand) checked @endif
                                                                onchange="document.getElementById('filter-form').submit()">
                                                            <label class="custom-control-label" for="brand-{{ $loop->index }}">{{ $brand }}</label>
                                                        </div><!-- End .custom-checkbox -->
                                                    </div><!-- End .filter-item -->
                                                    @endforeach
                                                </div><!-- End .filter-items -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .widget -->

                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                                Price
                                            </a>
                                        </h3><!-- End .widget-title -->

                                        <div class="collapse show" id="widget-5">
                                            <div class="widget-body">
                                                <div class="filter-price">
                                                    <div class="filter-price-text mb-2">
                                                        Price Range:
                                                    </div><!-- End .filter-price-text -->

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="min-price">Min:</label>
                                                            <input type="number" class="form-control" id="min-price" name="min_price" value="{{ request()->min_price ?? '' }}" placeholder="Min ₱">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="max-price">Max:</label>
                                                            <input type="number" class="form-control" id="max-price" name="max_price" value="{{ request()->max_price ?? '' }}" placeholder="Max ₱">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-3 text-center">
                                                        <button type="submit" class="btn btn-primary">Apply Price Filter</button>
                                                    </div>
                                                </div><!-- End .filter-price -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .widget -->
                                </form>
                			</div><!-- End .sidebar sidebar-shop -->
                		</aside><!-- End .col-lg-3 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->


 


    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/wNumb.js"></script>
    <script src="assets/js/bootstrap-input-spinner.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/nouislider.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    
    <script>
        $(document).ready(function () {
            // Only allow one checkbox to be checked at a time per filter group
            $('.filter-checkbox').on('change', function() {
                var name = $(this).attr('name');
                if(this.checked) {
                    $('input[name="' + name + '"]').not(this).prop('checked', false);
                }
            });
        });
    </script>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize star ratings with pixel-based calculations
        function initializeListStars() {
            $('.ratings-val').each(function() {
                const ratingContainer = $(this).parent();
                const totalWidth = ratingContainer.width();
                
                // Get the average rating value (already stored as percentage in data-width)
                const avgPercentage = $(this).data('width') || 0;
                const avgRating = avgPercentage / 20; // Convert to 0-5 scale
                
                // For 5-star ratings, ensure they fill completely
                if (avgRating >= 4.9) {
                    $(this).css('width', '100%');
                } else {
                    // For other ratings, add a small adjustment factor
                    const adjustedRating = avgRating * 1.03; // Apply a 3% adjustment
                    // Calculate width in pixels with adjustment
                    const filledWidth = Math.min((adjustedRating / 5) * totalWidth, totalWidth);
                    // Apply the width
                    $(this).css('width', filledWidth + 'px');
                }
            });
        }
        
        // Run on page load
        initializeListStars();
        
        // Multiple retries to ensure correct display
        setTimeout(initializeListStars, 200);
        setTimeout(initializeListStars, 500);
        setTimeout(initializeListStars, 1000);
        
        // Run when all images are loaded (which can affect layout)
        $(window).on('load', function() {
            initializeListStars();
            setTimeout(initializeListStars, 300);
        });
        
        // Fix on window resize
        $(window).on('resize', function() {
            setTimeout(initializeListStars, 100);
        });
        
        // Only allow one checkbox to be checked at a time per filter group
        $('.filter-checkbox').on('change', function() {
            var name = $(this).attr('name');
            if(this.checked) {
                $('input[name="' + name + '"]').not(this).prop('checked', false);
            }
        });
    });
</script>
@endsection

</body>


<!-- molla/category.html  22 Nov 2019 10:02:52 GMT -->
</html>
@endsection