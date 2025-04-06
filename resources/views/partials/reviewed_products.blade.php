@if(count($reviews) > 0)
    <div class="row">
        @foreach($reviews as $review)
            <div class="col-md-6 mb-4">
                <div class="product-review-card border p-3 h-100">
                    <div class="d-flex mb-3">
                        @if($review->product && $review->product->main_image)
                            <img src="{{ asset($review->product->main_image) }}" alt="{{ $review->product->name }}" class="mr-3" style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div>
                            <h5>{{ $review->product ? $review->product->name : 'Product' }}</h5>
                            <p class="text-muted small mb-0">
                                Order #{{ $review->order ? $review->order->order_number : 'N/A' }} | {{ $review->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Review Display -->
                    <div id="review-display-{{ $review->id }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 mr-2">Your Review</h6>
                                <div class="ratings-container mb-0">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{ $review->rating * 20 }}%;" data-width="{{ $review->rating * 20 }}"></div>
                                    </div>
                                    <span class="ratings-text" data-rating="{{ $review->rating }}">({{ $review->rating }}/5)</span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary edit-review-btn" 
                                    data-review-id="{{ $review->id }}" 
                                    data-current-rating="{{ $review->rating }}">
                                <i class="icon-edit"></i> Edit
                            </button>
                        </div>
                        <p>{{ $review->review }}</p>
                        <small class="text-muted">Reviewed on {{ $review->created_at->format('F d, Y') }}</small>
                    </div>
                    
                    <!-- Edit Form (initially hidden) -->
                    <div id="review-edit-form-{{ $review->id }}" style="display: none;">
                        <form action="{{ route('product.review.update', $review->id) }}" method="POST" class="review-edit-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="rating" id="edit-rating-value-{{ $review->id }}" value="{{ $review->rating }}">
                            
                            <div class="form-group">
                                <label>Your Rating</label>
                                <div class="star-rating">
                                    <div class="stars-container" id="edit-stars-container-{{ $review->id }}" data-item-id="{{ $review->id }}">
                                        @for($i = 5; $i >= 1; $i--)
                                            <i class="icon-star{{ $i <= $review->rating ? '' : '-o' }} star-btn" 
                                               data-rating="{{ $i }}" 
                                               title="{{ $i }} stars"></i>
                                        @endfor
                                    </div>
                                    <span class="sr-only">Current rating: {{ $review->rating }}/5</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit-review-{{ $review->id }}">Your Review</label>
                                <textarea id="edit-review-{{ $review->id }}" name="review" class="form-control" rows="3" required>{{ $review->review }}</textarea>
                            </div>
                            
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">
                                    <span>Update Review</span>
                                </button>
                                <button type="button" class="btn btn-outline-secondary cancel-edit-btn" data-review-id="{{ $review->id }}">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <p>You haven't submitted any reviews yet.</p>
        <p>Go to the "Products to Review" tab to start reviewing your purchases.</p>
    </div>
@endif 