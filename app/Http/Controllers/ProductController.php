<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function getcategory()
    {
        $categories = $this->getCategoriesWithLimitedProducts();
        return view('product.category.list', compact('categories'));
    }
    
    public function list(Request $request)
    {
        try {
            // Start with base query
            $query = ProductModel::where('status', 'in_stock');
            
            // Apply filters based on request parameters
            // Category filter
            if ($request->has('category') && $request->category) {
                $query->where('category_id', $request->category);
            }
            
            // Size filter
            if ($request->has('size') && $request->size) {
                $query->where('size', $request->size);
            }
            
            // Color filter
            if ($request->has('color') && $request->color) {
                $query->where('color', $request->color);
            }
            
            // Brand filter
            if ($request->has('brand') && $request->brand) {
                $query->where('brand', $request->brand);
            }
            
            // Price range filter
            if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '' && 
                $request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
                $query->whereBetween('new_price', [$request->min_price, $request->max_price]);
            } else if ($request->has('min_price') && $request->min_price !== null && $request->min_price !== '') {
                $query->where('new_price', '>=', $request->min_price);
            } else if ($request->has('max_price') && $request->max_price !== null && $request->max_price !== '') {
                $query->where('new_price', '<=', $request->max_price);
            }
            
            // Get results
            $products = $query->orderBy('created_at', 'desc')->paginate(12);
            
            // Get filter data for sidebar
            $sidebar_categories = CategoryModel::where('status', 1)->get();
            $sizes = ProductModel::distinct()->whereNotNull('size')->pluck('size');
            $colors = ProductModel::distinct()->whereNotNull('color')->pluck('color');
            $brands = ProductModel::distinct()->whereNotNull('brand')->pluck('brand');
            
            // Get price range
            $priceRange = [
                'min' => ProductModel::min('new_price') ?: 0,
                'max' => ProductModel::max('new_price') ?: 10000
            ];
            
            // Transform product data to match view expectations
            $products->getCollection()->transform(function($product) {
                $product->title = $product->name;
                $product->price = $product->new_price;
                $product->old_price = $product->old_price;
                
                // Calculate discount percentage if old price exists
                if ($product->old_price && $product->old_price > $product->new_price) {
                    $discount = (($product->old_price - $product->new_price) / $product->old_price) * 100;
                    $product->discount_percentage = round($discount);
                } else {
                    $product->discount_percentage = 0;
                }
                
                // Set product image
                $product->product_image = $product->main_image;
                
                return $product;
            });
            
            // Set current filter values for the view
            $currentFilters = [
                'category' => $request->category,
                'size' => $request->size,
                'color' => $request->color,
                'brand' => $request->brand,
                'min_price' => $request->min_price,
                'max_price' => $request->max_price
            ];
            
            // Get categories with their products for the header dropdown
            $categories = $this->getCategoriesWithLimitedProducts();
            
            // Make sure products are loaded for each category
            foreach ($categories as $category) {
                if (!isset($category->limitedProducts) || $category->limitedProducts->isEmpty()) {
                    $category->limitedProducts = ProductModel::where('category_id', $category->id)
                                               ->where('status', 'in_stock')
                                               ->orderBy('created_at', 'desc')
                                               ->limit(3)
                                               ->get();
                }
            }
            
            return view('products.list', compact('products', 'sidebar_categories', 'categories', 'sizes', 'colors', 'brands', 'priceRange', 'currentFilters'));
        } catch (\Exception $e) {
            \Log::error('Error in product list: ' . $e->getMessage());
            $categories = $this->getCategoriesWithLimitedProducts();
            return view('products.list', ['products' => collect([]), 'categories' => $categories, 'sidebar_categories' => []]);
        }
    }
    
    /**
     * Display the product detail page
     */
    public function detail($id)
    {
        try {
            // Get the product with its category and created by relationships
            $product = ProductModel::with(['category', 'createdBy', 'relatedProducts', 'reviews.createdBy'])
                        ->where('id', $id)
                        ->where('status', 'in_stock')
                        ->firstOrFail();

            // Format the product for display
            $product->title = $product->name;
            $product->price = $product->new_price;
            
            // Calculate discount percentage if old price exists
            if ($product->old_price && $product->old_price > $product->new_price) {
                $discount = (($product->old_price - $product->new_price) / $product->old_price) * 100;
                $product->discount_percentage = round($discount);
            } else {
                $product->discount_percentage = 0;
            }

            // Get related products - either from explicit relationship or products in same category
            $relatedProducts = $product->relatedProducts;
            
            // If no explicit related products, get products from same category
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = ProductModel::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->where('status', 'in_stock')
                                    ->with('reviews')  // Load reviews for each related product
                                    ->limit(4)
                                    ->get();
            } else {
                // If we have explicit related products, load their reviews too
                $relatedProductIds = $relatedProducts->pluck('id')->toArray();
                $relatedProducts = ProductModel::whereIn('id', $relatedProductIds)
                                    ->with('reviews')
                                    ->get();
            }

            // Format related products
            $relatedProducts->transform(function($relatedProduct) {
                $relatedProduct->title = $relatedProduct->name;
                $relatedProduct->price = $relatedProduct->new_price;
                $relatedProduct->product_image = $relatedProduct->main_image;
                
                // Calculate discount for related products
                if ($relatedProduct->old_price && $relatedProduct->old_price > $relatedProduct->new_price) {
                    $discount = (($relatedProduct->old_price - $relatedProduct->new_price) / $relatedProduct->old_price) * 100;
                    $relatedProduct->discount_percentage = round($discount);
                } else {
                    $relatedProduct->discount_percentage = 0;
                }
                
                return $relatedProduct;
            });

            // Get product reviews
            $productReviews = $product->reviews;
            
            // Check if authenticated user has purchased this product
            $userPurchasedOrders = collect();
            if (auth()->check()) {
                $userPurchasedOrders = \App\Models\Order::where('user_id', auth()->id())
                    ->where('status', 'delivered')
                    ->whereHas('orderItems', function($query) use ($id) {
                        $query->where('product_id', $id);
                    })
                    ->with(['orderItems' => function($query) use ($id) {
                        $query->where('product_id', $id);
                    }])
                    ->get();
            }

            // Get categories for navigation
            $categories = $this->getCategoriesWithLimitedProducts();

            return view('products.detail', compact(
                'product', 
                'relatedProducts', 
                'categories', 
                'productReviews', 
                'userPurchasedOrders'
            ));
        } catch (\Exception $e) {
            // Handle not found or other errors
            return redirect()->route('products.list')->with('error', 'Product not found');
        }
    }
    
    /**
     * Get all active categories with exactly 3 products each
     */
    private function getCategoriesWithLimitedProducts()
    {
        try {
            // Get all active categories
            $categories = CategoryModel::where('status', 1)->get();
            
            // For each category, get up to 3 in-stock products
            foreach ($categories as $category) {
                $category->limitedProducts = ProductModel::where('category_id', $category->id)
                                             ->where('status', 'in_stock')
                                             ->orderBy('created_at', 'desc')
                                             ->limit(3)
                                             ->get();
            }
            
            return $categories;
        } catch (\Exception $e) {
            // Log the error but return an empty collection rather than failing
            \Log::error('Error loading categories with products: ' . $e->getMessage());
            return collect([]);
        }
    }
}
