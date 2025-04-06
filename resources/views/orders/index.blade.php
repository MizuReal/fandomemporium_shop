@extends('layouts.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Orders<span>Account</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <h3 class="card-title">Order History</h3>
                            
                            @if($orders->isEmpty())
                                <p>You haven't placed any orders yet. <a href="{{ route('products.list') }}">Continue shopping</a></p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-outline-primary-2 btn-sm">View Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            
                                <div class="mt-3">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <h3 class="card-title">Product Reviews</h3>
                            @if($orders->isEmpty())
                                <p>You need to place orders before you can review products.</p>
                            @else
                                <p>Share your feedback on products you've purchased.</p>
                                
                                <button id="show-product-reviews" class="btn btn-primary btn-block mb-3">
                                    <i class="icon-star"></i> Review Your Purchases
                                </button>
                                
                                @if(isset($recentReviews) && count($recentReviews) > 0)
                                    <h5 class="mt-4">Your Recent Reviews</h5>
                                    @foreach($recentReviews as $review)
                                        <div class="recent-review mb-3 p-2 border-bottom">
                                            <div class="d-flex align-items-center">
                                                @if($review->product && $review->product->main_image)
                                                    <img src="{{ asset($review->product->main_image) }}" alt="{{ $review->product->name }}" style="width: 40px; height: 40px; object-fit: cover;" class="mr-2">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $review->product ? $review->product->name : 'Product' }}</h6>
                                                    <div class="ratings-container mb-0">
                                                        <div class="ratings">
                                                            <div class="ratings-val" style="width: {{ $review->rating * 20 }}%;" data-width="{{ $review->rating * 20 }}"></div>
                                                        </div>
                                                        <span class="ratings-text" data-rating="{{ $review->rating }}">({{ $review->rating }}/5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Product Review Modal -->
<div class="modal fade" id="product-review-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review Your Purchases</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="review-products-tabs">
                    <ul class="nav nav-tabs" id="product-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="unreviewed-tab" data-toggle="tab" href="#unreviewed" role="tab">Products to Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviewed-tab" data-toggle="tab" href="#reviewed" role="tab">Your Reviews</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="product-tabContent">
                        <div class="tab-pane fade show active" id="unreviewed" role="tabpanel">
                            <div id="unreviewed-products-container" class="py-3">
                                <div class="text-center p-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="mt-2">Loading products...</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviewed" role="tabpanel">
                            <div id="reviewed-products-container" class="py-3">
                                <div class="text-center p-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="mt-2">Loading your reviews...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Open product review modal
        $('#show-product-reviews').on('click', function() {
            $('#product-review-modal').modal('show');
            
            // Load unreviewed products
            loadUnreviewedProducts();
            
            // Load reviewed products when tab clicked
            $('#reviewed-tab').on('click', function() {
                if (!$('#reviewed-products-container').data('loaded')) {
                    loadReviewedProducts();
                }
            });
        });
        
        function loadUnreviewedProducts() {
            $.ajax({
                url: '{{ route("product.reviews.unreviewed") }}',
                type: 'GET',
                success: function(response) {
                    $('#unreviewed-products-container').html(response.html);
                    $('#unreviewed-products-container').data('loaded', true);
                    
                    // Initialize star rating system for newly loaded products
                    initializeStarRating();
                }
            });
        }
        
        function loadReviewedProducts() {
            $.ajax({
                url: '{{ route("product.reviews.reviewed") }}',
                type: 'GET',
                success: function(response) {
                    $('#reviewed-products-container').html(response.html);
                    $('#reviewed-products-container').data('loaded', true);
                    
                    // Initialize star rating system for edit forms
                    initializeStarRating();
                }
            });
        }
        
        function initializeStarRating() {
            // Star rating system for clickable stars
            $('.stars-container .star-btn').on('click', function() {
                const rating = $(this).data('rating');
                const itemId = $(this).closest('.stars-container').data('item-id');
                const valueField = $(`#rating-value-${itemId}`);
                
                if (valueField.length) {
                    valueField.val(rating);
                } else {
                    // For edit forms
                    const reviewId = $(this).closest('.stars-container').attr('id').replace('edit-stars-container-', '');
                    $(`#edit-rating-value-${reviewId}`).val(rating);
                }
                
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
            
            // Fix displayed star ratings using pixel-based calculations
            $('.ratings-val').each(function() {
                const container = $(this).closest('.ratings-container');
                const ratingContainer = $(this).parent();
                const totalWidth = ratingContainer.width();
                
                // Get rating value from data attribute
                const ratingText = container.find('.ratings-text').attr('data-rating');
                if (ratingText) {
                    const rating = parseFloat(ratingText);
                    if (!isNaN(rating)) {
                        // For 5-star ratings, ensure they fill completely
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
            });
            
            // Toggle edit form for existing reviews
            $('.edit-review-btn').off('click').on('click', function() {
                const reviewId = $(this).data('review-id');
                $(`#review-display-${reviewId}`).hide();
                $(`#review-edit-form-${reviewId}`).show();
                
                // Set the current rating
                const currentRating = $(this).data('current-rating');
                const starsContainer = $(`#edit-stars-container-${reviewId}`);
                
                starsContainer.find('.star-btn').removeClass('icon-star').addClass('icon-star-o');
                starsContainer.find('.star-btn').each(function() {
                    const starRating = $(this).data('rating');
                    if (starRating <= currentRating) {
                        $(this).removeClass('icon-star-o').addClass('icon-star');
                    }
                });
                
                $(`#edit-rating-value-${reviewId}`).val(currentRating);
            });
            
            // Cancel editing review
            $('.cancel-edit-btn').off('click').on('click', function() {
                const reviewId = $(this).data('review-id');
                $(`#review-display-${reviewId}`).show();
                $(`#review-edit-form-${reviewId}`).hide();
            });
        }
        
        // Initial initialization
        initializeStarRating();
        
        // Multiple retries to ensure correct display
        setTimeout(initializeStarRating, 200);
        setTimeout(initializeStarRating, 500);
        
        // Fix on window resize
        $(window).on('resize', function() {
            setTimeout(initializeStarRating, 100); 
        });
    });
</script>
@endsection

@endsection 