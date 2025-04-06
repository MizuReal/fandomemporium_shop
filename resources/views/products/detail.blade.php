@extends('layouts.app')
@section('content')

<style>
    /* Fix the size of the main image container */
    .product-main-image {
        width: 100%;
        height: 480px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        background-color: #f8f8f8;
        margin-bottom: 20px;
    }
    
    /* Make the main image fit appropriately */
    #product-zoom {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        transition: all 0.3s;
    }
    
    /* Ensure the thumbnails are consistently sized */
    .product-image-gallery {
        margin-top: 10px;
    }
    
    .product-image-gallery .product-gallery-item {
        height: 80px;
        width: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border: 1px solid #ebebeb;
        background-color: #f8f8f8;
        overflow: hidden;
    }
    
    .product-image-gallery .product-gallery-item img {
        width: 70px;
        height: 70px;
        object-fit: contain;
    }
    
    /* Add active state styling */
    .product-image-gallery .product-gallery-item.active {
        border-color: #fcb941;
    }
    
    /* Custom zoom styles */
    .img-magnifier-container {
        position: relative;
    }
    
    .img-magnifier-glass {
        position: absolute;
        border: 2px solid #ebebeb;
        border-radius: 50%;
        cursor: none;
        width: 150px;
        height: 150px;
        display: none;
        background-repeat: no-repeat;
        z-index: 1000;
    }
    
    /* Rating stars fix */
    .product-details .ratings-container {
        display: flex;
        align-items: center;
        margin-bottom: 1.2rem;
    }
    
    .product-details .ratings {
        position: relative;
        height: 1.4rem;
        margin-right: 1rem;
        min-width: 5.5rem;
    }
    
    .product-details .ratings-text {
        font-size: 1.3rem;
        color: #666;
        font-weight: 400;
        margin-left: 0.5rem;
    }
    
    /* Form rating stars fix */
    .review-form .stars-container {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }
    
    .review-form .star-btn {
        font-size: 1.8rem !important;
        margin-right: 8px !important;
        cursor: pointer;
    }
</style>

<div class="page-content">
    <div class="container">
        <div class="product-details-top">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-gallery product-gallery-vertical">
                        <div class="row">
                            <figure class="product-main-image img-magnifier-container">
                                @if($product->main_image)
                                    <img id="product-zoom" src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                                    <div id="zoom-glass" class="img-magnifier-glass"></div>
                                @else
                                    <img id="product-zoom" src="{{ asset('home/assets/images/products/placeholder.jpg') }}" alt="{{ $product->name }}">
                                    <div id="zoom-glass" class="img-magnifier-glass"></div>
                                @endif

                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure>

                            <div id="product-zoom-gallery" class="product-image-gallery">
                                @if($product->main_image)
                                <a class="product-gallery-item active" href="#" data-image="{{ asset($product->main_image) }}">
                                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                                </a>
                                @endif

                                @if($product->image1)
                                <a class="product-gallery-item" href="#" data-image="{{ asset($product->image1) }}">
                                    <img src="{{ asset($product->image1) }}" alt="{{ $product->name }}">
                                </a>
                                @endif

                                @if($product->image2)
                                <a class="product-gallery-item" href="#" data-image="{{ asset($product->image2) }}">
                                    <img src="{{ asset($product->image2) }}" alt="{{ $product->name }}">
                                </a>
                                @endif

                                @if($product->image3)
                                <a class="product-gallery-item" href="#" data-image="{{ asset($product->image3) }}">
                                    <img src="{{ asset($product->image3) }}" alt="{{ $product->name }}">
                                </a>
                                @endif

                                @if($product->image4)
                                <a class="product-gallery-item" href="#" data-image="{{ asset($product->image4) }}">
                                    <img src="{{ asset($product->image4) }}" alt="{{ $product->name }}">
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <div class="ratings-container">
                            <div class="ratings">
                                @php
                                    // Calculate average rating percentage (5 stars = 100%)
                                    $avgRating = $productReviews->count() > 0 ? ($productReviews->avg('rating') / 5) * 100 : 0;
                                    // Add slight adjustment to ensure 5 stars show fully (product details page only)
                                    $displayRating = $avgRating >= 97 ? 100 : $avgRating * 1.12;
                                @endphp
                                <div class="ratings-val" style="width: {{ $displayRating }}%;" data-width="{{ $avgRating }}"></div>
                            </div>
                            <span class="ratings-text">
                                ({{ count($productReviews) }} {{ Str::plural('Review', count($productReviews)) }})
                            </span>
                        </div>

                        <div class="product-price">
                            @if($product->old_price && $product->old_price > $product->new_price)
                                <span class="new-price">₱{{ number_format($product->new_price, 2) }}</span>
                                <span class="old-price">₱{{ number_format($product->old_price, 2) }}</span>
                            @else
                                ₱{{ number_format($product->new_price, 2) }}
                            @endif
                        </div>

                        <div class="product-content">
                            <p>{{ $product->short_description }}</p>
                        </div>

                        @if($product->size)
                        <div class="details-filter-row details-row-size">
                            <label>Size:</label>
                            <div class="select-custom">
                                <select name="size" id="size" class="form-control">
                                    <option value="{{ $product->size }}" selected>{{ $product->size }}</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        @if($product->color)
                        <div class="details-filter-row details-row-size">
                            <label for="color">Color:</label>
                            <div class="select-custom">
                                <select name="color" id="color" class="form-control">
                                    <option value="{{ $product->color }}" selected>{{ $product->color }}</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="details-filter-row details-row-size">
                            <label for="qty">Qty:</label>
                            <div class="product-details-quantity">
                                <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                            </div>
                        </div>

                        <div class="product-details-action">
                            <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="cart-qty" value="1">
                                @if($product->color)
                                <input type="hidden" name="color" value="{{ $product->color }}">
                                @endif
                                @if($product->size)
                                <input type="hidden" name="size" value="{{ $product->size }}">
                                @endif
                                <button type="submit" class="btn-product btn-cart"><span>add to cart</span></button>
                            </form>
                        </div>

                        <div class="product-details-footer">
                            <div class="product-cat">
                                <span>Category: </span>
                                <a href="{{ route('products.list', ['category' => $product->category_id]) }}">{{ $product->category->name }} </a>
                            </div>

                            @if($product->brand)
                            <div class="product-cat">
                                <span>Brand: </span>
                                <a href="{{ route('products.list', ['brand' => $product->brand]) }}">{{ $product->brand }}</a>
                            </div>
                            @endif

                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-details-tab">
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ session('review_tab_active') ? '' : 'active' }}" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="{{ session('review_tab_active') ? 'false' : 'true' }}">Description</a>
                </li>
                @if($product->additional_information)
                <li class="nav-item">
                    <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ session('review_tab_active') ? 'active' : '' }}" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="{{ session('review_tab_active') ? 'true' : 'false' }}">Reviews ({{ count($productReviews) }})</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade {{ session('review_tab_active') ? '' : 'show active' }}" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        <h3>Product Information</h3>
                        {{ $product->description }}
                    </div>
                </div>
                
                @if($product->additional_information)
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <h3>Additional Information</h3>
                        {{ $product->additional_information }}
                    </div>
                </div>
                @endif

                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        <h3>Delivery & returns</h3>
                        <p>Thank you for trusting FandomEmporium <br>
                        We hope you'll love every purchase, but if you ever need to return an item you can do so within a month of receipt.</p>
                    </div>
                </div>

                <div class="tab-pane fade {{ session('review_tab_active') ? 'show active' : '' }}" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                    <div class="reviews">
                        <h3>Reviews ({{ count($productReviews) }})</h3>
                        
                        @if(count($productReviews) > 0)
                            @foreach($productReviews as $review)
                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4>{{ $review->createdBy ? $review->createdBy->name : 'Anonymous' }}</h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                @php
                                                    // Calculate exact percentage for the rating (5 stars = 100%)
                                                    $reviewRating = ($review->rating / 5) * 100;
                                                @endphp
                                                <div class="ratings-val" style="width: {{ $reviewRating }}%;" data-width="{{ $reviewRating }}"></div>
                                            </div>
                                            <span class="ratings-text" data-rating="{{ $review->rating }}">({{ $review->rating }}/5)</span>
                                        </div>
                                        <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="col">
                                        <div class="review-content">
                                            <p>{{ $review->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p>This product has not been reviewed yet. Be the first to share your experience!</p>
                        @endif

                        @auth
                            @php
                                $userReview = $productReviews->where('user_id', auth()->id())->first();
                                $userOrder = $userPurchasedOrders->first();
                            @endphp
                            
                            @if($userPurchasedOrders->count() > 0)
                                @if($userReview)
                                    <div class="card card-dashboard mt-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h4 class="mb-1">Your Review</h4>
                                                    <p class="mb-0">Thanks for sharing your feedback with other customers!</p>
                                                </div>
                                                <button type="button" class="btn btn-outline-primary" id="edit-review-btn">
                                                    <i class="icon-edit"></i> Edit Review
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="edit-review-form" class="card card-dashboard mt-4" style="display: none;">
                                        <div class="card-body">
                                            <h3 class="card-title">Edit Your Review</h3>
                                            <form action="{{ route('product.review.update', $userReview->id) }}" method="POST" class="review-validation-form" data-validate="rating">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="edit-review-rating">Your Rating <span class="text-danger">*</span></label>
                                                    <div class="stars-container mb-2" id="edit-stars-container">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <i class="icon-star{{ old('rating', $userReview->rating) >= $i ? '' : '-o' }} star-btn" data-rating="{{ $i }}" title="{{ $i }} stars"></i>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="edit-rating-value" value="{{ old('rating', $userReview->rating) }}">
                                                    <div class="rating-error text-danger" style="display: {{ $errors->has('rating') || session('review_error') ? 'block' : 'none' }};">
                                                        {{ $errors->has('rating') ? $errors->first('rating') : 'Please select a rating.' }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-review-message">Your Review <span class="text-danger">*</span></label>
                                                    <textarea id="edit-review-message" name="review" class="form-control" rows="6" required>{{ old('review', $userReview->review) }}</textarea>
                                                    @error('review')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <span>Update Review</span>
                                                        <i class="icon-long-arrow-right"></i>
                                                    </button>
                                                    <button type="button" id="cancel-edit-btn" class="btn btn-outline-secondary">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-dashboard mt-4">
                                        <div class="card-body">
                                            <h3 class="card-title">Leave a Review</h3>
                                            <p>Share your thoughts about this product with other customers</p>
                                            <form action="{{ route('product.review.store') }}" method="POST" class="review-validation-form" data-validate="rating">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="order_id" value="{{ $userOrder->id }}">
                                                <input type="hidden" name="rating" id="rating-value" value="{{ old('rating') }}">
                                                
                                                <div class="form-group">
                                                    <label for="review-rating">Your Rating <span class="text-danger">*</span></label>
                                                    <div class="stars-container mb-2">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <i class="icon-star{{ old('rating') == $i ? '' : '-o' }} star-btn" data-rating="{{ $i }}" title="{{ $i }} stars"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="rating-error text-danger" style="display: {{ $errors->has('rating') || session('review_error') ? 'block' : 'none' }};">
                                                        {{ $errors->has('rating') ? $errors->first('rating') : 'Please select a rating.' }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="review-message">Your Review <span class="text-danger">*</span></label>
                                                    <textarea id="review-message" name="review" class="form-control" rows="6" required placeholder="What did you like or dislike about this product? How was the quality? Would you recommend it to others?">{{ old('review') }}</textarea>
                                                    @error('review')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-outline-primary-2">
                                                    <span>Submit Review</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="card card-dashboard mt-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="review-status-icon mr-3">
                                                <i class="icon-shopping-cart" style="font-size: 2rem; color: #fcb941;"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-1">Verified Purchase Required</h4>
                                                <p class="mb-2">You need to purchase this product before you can leave a review.</p>
                                                <button form="addToCartForm" type="submit" class="btn btn-outline-primary-2">
                                                    <span>Add to Cart</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="card card-dashboard mt-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="review-status-icon mr-3">
                                            <i class="icon-user" style="font-size: 2rem; color: #6F42C1;"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1">Sign In Required</h4>
                                            <p class="mb-2">Please sign in to write a review for this product.</p>
                                            <a href="#signin-modal" data-toggle="modal" class="btn btn-outline-primary-2">
                                                <span>Sign In / Register</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <h2 class="title text-center mb-4">You May Also Like</h2>
        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
            data-owl-options='{
                "nav": false, 
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":1
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
            @foreach($relatedProducts as $relatedProduct)
            <div class="product product-7 text-center">
                <figure class="product-media">
                    @if($relatedProduct->discount_percentage > 0)
                    <span class="product-label label-sale">{{ $relatedProduct->discount_percentage }}% Off</span>
                    @endif
                    
                    <a href="{{ route('products.detail', $relatedProduct->id) }}">
                        @if($relatedProduct->main_image)
                        <img src="{{ asset($relatedProduct->main_image) }}" alt="{{ $relatedProduct->name }}" class="product-image">
                        @else
                        <img src="{{ asset('assets/images/products/placeholder.jpg') }}" alt="{{ $relatedProduct->name }}" class="product-image">
                        @endif
                    </a>

                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                        <a href="#" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                        <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                    </div>

                    <div class="product-action">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-product btn-cart"><span>add to cart</span></button>
                        </form>
                    </div>
                </figure>

                <div class="product-body">
                    <div class="product-cat">
                        <a href="{{ route('products.list', ['category' => $relatedProduct->category_id]) }}">{{ $relatedProduct->category->name }}</a>
                    </div>
                    <h3 class="product-title"><a href="{{ route('products.detail', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h3>
                    <div class="product-price">
                        @if($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->new_price)
                            <span class="new-price">₱{{ number_format($relatedProduct->new_price, 2) }}</span>
                            <span class="old-price">₱{{ number_format($relatedProduct->old_price, 2) }}</span>
                        @else
                            ₱{{ number_format($relatedProduct->new_price, 2) }}
                        @endif
                    </div>
                    <div class="ratings-container">
                        <div class="ratings">
                            @php
                                // Calculate average rating percentage (5 stars = 100%)
                                $avgRating = $relatedProduct->reviews ? ($relatedProduct->reviews->avg('rating') / 5) * 100 : 0;
                            @endphp
                            <div class="ratings-val" style="width: {{ $avgRating }}%;" data-width="{{ $avgRating }}"></div>
                        </div>
                        <span class="ratings-text">
                            ({{ $relatedProduct->reviews ? $relatedProduct->reviews->count() : 0 }})
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var magnifyGlass = document.getElementById("zoom-glass");
        var productZoom = document.getElementById("product-zoom");
        var mainImageContainer = document.querySelector(".product-main-image");
        var zoomActive = false;
        var zoomScale = 2; // Zoom magnification level
        
        // Set up magnifier glass
        function magnify() {
            magnifyGlass.style.backgroundImage = "url('" + productZoom.src + "')";
            
            magnifyGlass.addEventListener("mousemove", moveMagnifier);
            productZoom.addEventListener("mousemove", moveMagnifier);
            
            magnifyGlass.addEventListener("touchmove", moveMagnifier);
            productZoom.addEventListener("touchmove", moveMagnifier);
            
            // Show magnifying glass on hover
            productZoom.addEventListener("mouseenter", function() {
                magnifyGlass.style.display = "block";
                zoomActive = true;
            });
            
            // Hide magnifying glass when mouse leaves
            mainImageContainer.addEventListener("mouseleave", function() {
                magnifyGlass.style.display = "none";
                zoomActive = false;
            });
        }
        
        // Move magnifier glass
        function moveMagnifier(e) {
            var pos, x, y;
            e.preventDefault();
            
            // Calculate cursor position relative to the image
            var rect = productZoom.getBoundingClientRect();
            var imgWidth = productZoom.offsetWidth;
            var imgHeight = productZoom.offsetHeight;
            
            // Get cursor position
            pos = getCursorPos(e, rect);
            x = pos.x;
            y = pos.y;
            
            // Prevent glass from going outside image
            if (x > imgWidth || x < 0 || y > imgHeight || y < 0) {
                magnifyGlass.style.display = "none";
                return;
            } else if (zoomActive) {
                magnifyGlass.style.display = "block";
            }
            
            // Calculate position of the magnifying glass
            x = x - (magnifyGlass.offsetWidth / 2);
            y = y - (magnifyGlass.offsetHeight / 2);
            
            // Set the position of the magnifying glass
            magnifyGlass.style.left = x + "px";
            magnifyGlass.style.top = y + "px";
            
            // Calculate background position for the magnifying glass
            var bgX = x * zoomScale;
            var bgY = y * zoomScale;
            
            // Set the background position
            magnifyGlass.style.backgroundSize = (imgWidth * zoomScale) + "px " + (imgHeight * zoomScale) + "px";
            magnifyGlass.style.backgroundPosition = "-" + bgX + "px -" + bgY + "px";
        }
        
        // Get cursor position
        function getCursorPos(e, rect) {
            var x = 0, y = 0;
            e = e || window.event;
            
            // Get cursor coordinates
            x = e.pageX - rect.left - window.pageXOffset;
            y = e.pageY - rect.top - window.pageYOffset;
            
            return {x : x, y : y};
        }
        
        // Initialize magnifier on page load
        magnify();

        // Handle thumbnail clicks
        $('.product-gallery-item').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var imgSrc = $this.data('image');
            
            // Update main image
            $('#product-zoom').attr('src', imgSrc);
            
            // Update active state
            $('.product-gallery-item').removeClass('active');
            $this.addClass('active');
            
            // Reinitialize magnifier with a slight delay
            setTimeout(function() {
                magnify();
            }, 100);
        });

        // Open product gallery lightbox
        $('#btn-product-gallery').on('click', function (e) {
            e.preventDefault();
            
            var images = [];
            
            // Collect all gallery images for lightbox
            $('.product-gallery-item').each(function() {
                var imgSrc = $(this).data('image');
                if (imgSrc) {
                    images.push({
                        src: imgSrc
                    });
                }
            });
            
            $.magnificPopup.open({
                items: images,
                type: 'image',
                gallery:{
                    enabled:true
                }
            }, 0); // Open first image
        });

        // Cart quantity sync
        $('#qty').on('change', function() {
            $('#cart-qty').val($(this).val());
        });
        
        // Star rating system
        $('.star-btn').on('click', function() {
            const rating = $(this).data('rating');
            const valueField = $(this).closest('form').find('input[name="rating"]');
            
            valueField.val(rating);
            
            // Reset all stars first
            $(this).parent().find('.star-btn').each(function() {
                const starRating = $(this).data('rating');
                if (starRating <= rating) {
                    $(this).removeClass('icon-star-o').addClass('icon-star');
                } else {
                    $(this).removeClass('icon-star').addClass('icon-star-o');
                }
            });
        });
        
        // Edit review button
        $('#edit-review-btn').on('click', function() {
            $(this).closest('.card').hide();
            $('#edit-review-form').show();
        });
        
        // Cancel edit review
        $('#cancel-edit-btn').on('click', function() {
            $('#edit-review-form').hide();
            $('#edit-review-btn').closest('.card').show();
        });

        // Initialize star ratings display
        function initializeStars() {
            // Get the width of a single star including spacing
            function getStarWidth(container) {
                return container.width() / 5; // 5 stars in container
            }
            
            // Process all ratings
            $('.ratings-val').each(function() {
                const container = $(this).closest('.ratings-container');
                const ratingContainer = $(this).parent();
                const totalWidth = ratingContainer.width();
                
                // Different calculation based on rating type
                if (container.closest('.review').length || 
                    container.closest('.recent-review').length || 
                    container.closest('#reviewed-products-container').length) {
                    
                    // Individual review - get rating from data attribute
                    const ratingText = container.find('.ratings-text').attr('data-rating');
                    if (ratingText) {
                        const rating = parseFloat(ratingText);
                        if (!isNaN(rating)) {
                            // For 5-star ratings, ensure they show completely filled
                            if (rating >= 4.9) {
                                $(this).css('width', '100%');
                            } else {
                                // For other ratings, add a small adjustment factor
                                const adjustedRating = rating * 1.03; // Apply a 3% adjustment
                                // Calculate width in pixels with adjustment
                                const filledWidth = Math.min((adjustedRating / 5) * totalWidth, totalWidth);
                                // Apply precise width in pixels
                                $(this).css('width', filledWidth + 'px');
                            }
                        }
                    }
                } else {
                    // Average rating from data-width attribute (already in percentage)
                    const avgRating = $(this).data('width') / 20; // Convert to 0-5 scale
                    
                    // For consistent display, use pixels instead of percentages
                    const filledWidth = (avgRating / 5) * totalWidth;
                    $(this).css('width', filledWidth + 'px');
                    
                    // Ensure 5 stars show completely
                    if (avgRating >= 4.95) {
                        $(this).css('width', totalWidth + 'px');
                    }
                }
            });
            
            // Edit review form stars
            const editRating = $('#edit-rating-value').val();
            if (editRating) {
                $('#edit-stars-container .star-btn').each(function() {
                    const starRating = $(this).data('rating');
                    if (starRating <= editRating) {
                        $(this).removeClass('icon-star-o').addClass('icon-star');
                    } else {
                        $(this).removeClass('icon-star').addClass('icon-star-o');
                    }
                });
            }
        }
        
        // Run initialization on page load
        initializeStars();
        
        // Multiple attempts to ensure stars are rendered correctly
        setTimeout(initializeStars, 200);
        setTimeout(initializeStars, 500);
        setTimeout(initializeStars, 1000);
        
        // Run again when all images are loaded
        $(window).on('load', function() {
            initializeStars();
            setTimeout(initializeStars, 300);
        });
        
        // Fix on window resize
        $(window).on('resize', function() {
            setTimeout(initializeStars, 100);
        });

        // Re-run initialization whenever new reviews are loaded via Ajax
        $(document).ajaxComplete(function(event, xhr, settings) {
            if (settings.url.includes('review')) {
                setTimeout(function() {
                    initializeStars();
                }, 100);
            }
        });

        // Show success/error message if exists using toastr
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        
        // Validate product review rating
        function validateProductRating(form) {
            const ratingInput = form.querySelector('input[name="rating"]');
            const ratingError = form.querySelector('.rating-error');
            
            if (!ratingInput || !ratingInput.value) {
                if (ratingError) {
                    ratingError.textContent = 'Please select a rating.';
                    ratingError.style.display = 'block';
                }
                
                // Focus on the rating section
                const starsContainer = form.querySelector('.stars-container');
                if (starsContainer) {
                    starsContainer.scrollIntoView({behavior: 'smooth', block: 'center'});
                }
                
                // Prevent any form submission
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            
            if (ratingError) {
                ratingError.style.display = 'none';
            }
            return true;
        }
        
        // Add event listeners directly to the forms
        document.querySelectorAll('form[action="{{ route('product.review.store') }}"], form[action^="{{ route('product.review.update', '') }}"]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!validateProductRating(this)) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            });
        });
        
        // Clear error message when a rating is selected
        $('.star-btn').on('click', function() {
            const form = $(this).closest('form');
            const ratingError = form.find('.rating-error');
            if (ratingError.length) {
                ratingError.hide();
            }
        });
    });
</script>
@endsection