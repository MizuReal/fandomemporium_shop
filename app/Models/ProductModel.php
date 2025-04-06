<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProductModel extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'products';
    
    protected $fillable = [
        'name', 'category_id', 'size', 'color', 'old_price', 'new_price', 
        'brand', 'short_description', 'description', 'additional_information', 
        'main_image', 'image1', 'image2', 'image3', 'image4',
        'status', 'created_by_id'
    ];
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
    
    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    
    /**
     * Get the user who created the product
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    
    /**
     * Get the related products for this product
     */
    public function relatedProducts()
    {
        return $this->belongsToMany(ProductModel::class, 'related_products', 'product_id', 'related_product_id')
            ->withTimestamps();
    }
    
    /**
     * Get the reviews for this product
     */
    public function reviews()
    {
        return $this->hasMany(ProductReviewModel::class, 'product_id');
    }
} 