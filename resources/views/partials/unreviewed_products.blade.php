@if(count($unreviewedProducts) > 0)
    <div class="row">
        @foreach($unreviewedProducts as $item)
            <div class="col-md-6 mb-4">
                <div class="product-review-card border p-3 h-100">
                    <div class="d-flex mb-3">
                        @if($item->product && $item->product->main_image)
                            <img src="{{ asset($item->product->main_image) }}" alt="{{ $item->product->name }}" class="mr-3" style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div>
                            <h5>{{ $item->product->name }}</h5>
                            <p class="text-muted small mb-0">
                                Order #{{ $item->order->order_number }} | {{ $item->order->created_at->format('M d, Y') }}
                                @if($item->size || $item->color)
                                    <br>
                                    @if($item->color) Color: {{ $item->color }} @endif
                                    @if($item->size) @if($item->color), @endif Size: {{ $item->size }} @endif
                                @endif
                            </p>
                        </div>
                    </div>
                    
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
                                        <i class="icon-star-o star-btn" data-rating="{{ $i }}" title="{{ $i }} stars" style="font-size: 1.8rem; margin-right: 8px;"></i>
                                    @endfor
                                </div>
                                <div class="rating-error text-danger" style="display: none;">Please select a rating.</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="review-{{ $item->id }}">Your Review <span class="text-danger">*</span></label>
                            <textarea id="review-{{ $item->id }}" name="review" class="form-control" rows="3" required placeholder="Share your experience with this product"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <span>Submit Review</span>
                            <i class="icon-long-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <p>You have reviewed all your purchased products.</p>
        <p>Check the "Your Reviews" tab to see and edit your existing reviews.</p>
    </div>
@endif 

<script>
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
    
    // Clear error message when a rating is selected
    document.querySelectorAll('.star-btn').forEach(function(star) {
        star.addEventListener('click', function() {
            const form = this.closest('form');
            const ratingError = form.querySelector('.rating-error');
            ratingError.style.display = 'none';
        });
    });
</script> 