<?php

namespace App\Http\Controllers;

use App\Models\ProductReviewModel;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created product review in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'order_id' => 'required|exists:orders,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('review_tab_active', true) // Flag to ensure review tab stays open
                    ->with('review_error', true); // Flag to specifically handle review errors
            }

            // Filter out bad words
            $filteredReview = $this->filterBadWords($request->review);

            // Check if user has already reviewed this product for this order
            $existingReview = ProductReviewModel::where('product_id', $request->product_id)
                ->where('order_id', $request->order_id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingReview) {
                // Update existing review
                $existingReview->rating = $request->rating;
                $existingReview->review = $filteredReview;
                $existingReview->save();

                return redirect()->back()->with('success', 'Your review has been updated successfully.');
            }

            // Create new review
            $review = new ProductReviewModel();
            $review->product_id = $request->product_id;
            $review->order_id = $request->order_id;
            $review->user_id = Auth::id();
            $review->rating = $request->rating;
            $review->review = $filteredReview;
            $review->save();

            return redirect()->back()->with('success', 'Your review has been submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your review. Please try again.')
                ->with('review_tab_active', true);
        }
    }
    
    /**
     * Update an existing review
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('review_tab_active', true) // Flag to ensure review tab stays open
                    ->with('review_error', true); // Flag to specifically handle review errors
            }

            // Filter out bad words
            $filteredReview = $this->filterBadWords($request->review);

            // Find the review and make sure it belongs to the logged-in user
            $review = ProductReviewModel::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Update review
            $review->rating = $request->rating;
            $review->review = $filteredReview;
            $review->save();

            return redirect()->back()->with('success', 'Your review has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating your review. Please try again.')
                ->with('review_tab_active', true);
        }
    }
    
    /**
     * Get unreviewed products for the modal
     */
    public function getUnreviewedProducts(Request $request)
    {
        // Get products from delivered orders
        $deliveredOrders = Order::where('user_id', auth()->id())
                        ->where('status', 'delivered')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        $unreviewedProducts = [];
        
        foreach ($deliveredOrders as $order) {
            $orderItems = OrderItem::where('order_id', $order->id)
                        ->with('product')
                        ->get();
            
            foreach ($orderItems as $item) {
                if ($item->product) {
                    // Check if user has already reviewed this product
                    $existingReview = ProductReviewModel::where('product_id', $item->product_id)
                        ->where('order_id', $order->id)
                        ->where('user_id', auth()->id())
                        ->first();
                    
                    if (!$existingReview) {
                        // Clone to avoid modifying the original
                        $reviewItem = clone $item;
                        $reviewItem->order = $order;
                        $unreviewedProducts[] = $reviewItem;
                    }
                }
            }
        }
        
        $html = View::make('partials.unreviewed_products', compact('unreviewedProducts'))->render();
        
        return response()->json([
            'html' => $html
        ]);
    }
    
    /**
     * Get reviewed products for the modal
     */
    public function getReviewedProducts(Request $request)
    {
        $reviews = ProductReviewModel::where('user_id', auth()->id())
                ->with(['product', 'order'])
                ->orderBy('created_at', 'desc')
                ->get();
        
        $html = View::make('partials.reviewed_products', compact('reviews'))->render();
        
        return response()->json([
            'html' => $html
        ]);
    }
    
    /**
     * Load more products for review via AJAX
     */
    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = 3; // Number of additional products to load
        
        // Get products from delivered orders for review section
        $deliveredOrders = Order::where('user_id', auth()->id())
                          ->where('status', 'delivered')
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        $reviewableProducts = [];
        $productCount = 0;
        $totalCount = 0;
        $hasMore = false;
        
        if ($deliveredOrders->isNotEmpty()) {
            foreach ($deliveredOrders as $order) {
                $orderItems = OrderItem::where('order_id', $order->id)
                            ->with('product')
                            ->get();
                
                foreach ($orderItems as $item) {
                    if ($item->product) {
                        if ($totalCount >= $offset) {
                            // Check if user has already reviewed this product
                            $existingReview = ProductReviewModel::where('product_id', $item->product_id)
                                ->where('order_id', $order->id)
                                ->where('user_id', auth()->id())
                                ->first();
                            
                            $reviewItem = clone $item;
                            $reviewItem->existingReview = $existingReview;
                            $reviewItem->order = $order;
                            
                            if ($productCount < $limit) {
                                $reviewableProducts[] = $reviewItem;
                                $productCount++;
                            } else {
                                $hasMore = true;
                                break 2; // Break both loops once we hit the limit
                            }
                        }
                        $totalCount++;
                    }
                }
            }
        }
        
        $html = '';
        if (count($reviewableProducts) > 0) {
            $html = View::make('partials.product_review_items', compact('reviewableProducts'))->render();
        }
        
        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore
        ]);
    }

    /**
     * Filter bad words from text, replacing them with [redacted]
     * 
     * @param string $text The text to filter
     * @return string The filtered text with bad words replaced
     */
    private function filterBadWords($text)
    {
        // List of bad words to filter
        $badWords = [
            'fuck', 'f[u\*]ck', 'f+u+c+k+',
            'shit', 'sh[i\*]t',
            'bitch', 'b[i\*]tch',
            'asshole', 'a[s\*][s\*]hole',
            'damn', 
            'nigger', 'n[i\*]gger',
            'bastard',
            'cunt', 'c[u\*]nt',
            'whore',
            'dick', 'd[i\*]ck'
        ];
        
        // Build the regex pattern
        $pattern = '/\b(' . implode('|', $badWords) . ')\b/i';
        
        // Replace bad words with [redacted]
        return preg_replace($pattern, '[redacted]', $text);
    }
} 