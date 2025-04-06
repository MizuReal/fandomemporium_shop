<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewModel extends Model
{
    use HasFactory;

    protected $table = 'product_review';
    
    protected $fillable = [
        'product_id', 'order_id', 'user_id', 'rating', 'review'
    ];
    
    /**
     * Get the user who created this review
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the product this review is for
     */
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
    
    /**
     * Get the order this review is associated with
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
