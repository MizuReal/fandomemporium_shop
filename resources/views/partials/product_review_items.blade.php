@foreach($reviewableProducts as $item)
    <div class="product-review-section mb-4 pt-2 border-top">
        <div class="d-flex align-items-center mb-2">
            @if($item->product && $item->product->main_image)
                <img src="{{ asset($item->product->main_image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="mr-3">
            @endif
            <div>
                <h5 class="mb-0">{{ $item->product->name }}</h5>
                <small class="text-muted">Order #{{ $item->order->order_number }}</small>
            </div>
        </div>
        
        @if($item->existingReview)
            <div class="card card-dashboard mb-3 p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Your Review</h6>
                        <div class="ratings-container mb-0">
                            <div class="ratings">
                                <div class="ratings-val" style="width: {{ $item->existingReview->rating * 20 }}%;" data-width="{{ $item->existingReview->rating * 20 }}"></div>
                            </div>
                            <span class="ratings-text">({{ $item->existingReview->rating }}/5)</span>
                        </div>
                    </div>
                    <p class="mb-0">{{ $item->existingReview->review }}</p>
                </div>
            </div>
        @else
            <div class="compact-review-form">
                <form action="{{ route('product.review.store') }}" method="POST" class="review-form" onsubmit="return validateRating(this);">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    <input type="hidden" name="order_id" value="{{ $item->order_id }}">
                    <input type="hidden" name="rating" id="rating-value-{{ $item->id }}" value="">
                    
                    <div class="form-group">
                        <label>Your Rating <span class="text-danger">*</span></label>
                        <div class="star-rating">
                            <div class="stars-container" data-item-id="{{ $item->id }}">
                                @for($i = 5; $i >= 1; $i--)
                                    <i class="icon-star-o star-btn" data-rating="{{ $i }}" title="{{ $i }} stars"></i>
                                @endfor
                            </div>
                            <div class="rating-error text-danger" style="display: none;">Please select a rating.</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="review-{{ $item->id }}">Your Review <span class="text-danger">*</span></label>
                        <textarea id="review-{{ $item->id }}" name="review" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <span>Submit Review</span>
                        <i class="icon-long-arrow-right"></i>
                    </button>
                </form>
            </div>
        @endif
    </div>
@endforeach

<script>
    // Initialize star rating functionality for newly loaded items
    $(document).ready(function() {
        // Star rating system for newly loaded items
        $('.stars-container .star-btn').on('click', function() {
            const rating = $(this).data('rating');
            const itemId = $(this).closest('.stars-container').data('item-id');
            
            // Update hidden input with selected rating
            $(`#rating-value-${itemId}`).val(rating);
            
            // Reset all stars first
            $(this).parent().find('.star-btn').each(function() {
                const starRating = $(this).data('rating');
                if (starRating <= rating) {
                    $(this).removeClass('icon-star-o').addClass('icon-star');
                } else {
                    $(this).removeClass('icon-star').addClass('icon-star-o');
                }
            });
            
            // Hide error message if visible
            $(this).closest('.star-rating').find('.rating-error').hide();
        });
    });
    
    // Client-side validation for the rating field
    function validateRating(form) {
        const ratingInput = form.querySelector('input[name="rating"]');
        const ratingError = form.querySelector('.rating-error');
        
        if (!ratingInput.value) {
            ratingError.style.display = 'block';
            return false;
        }
        
        ratingError.style.display = 'none';
        return true;
    }
</script> 