<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReviewModel;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for admin.
     */
    public function list()
    {
        $reviews = ProductReviewModel::with(['product', 'createdBy', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.reviews.list', compact('reviews'));
    }

    /**
     * Delete a review.
     */
    public function delete($id)
    {
        try {
            $review = ProductReviewModel::findOrFail($id);
            $review->delete();
            
            return redirect('admin/reviews/list')->with('success', 'Review deleted successfully');
        } catch (\Exception $e) {
            return redirect('admin/reviews/list')->with('error', 'Failed to delete review: ' . $e->getMessage());
        }
    }
} 