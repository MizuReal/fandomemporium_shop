<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class HomeController extends Controller
{
    public function home()
    {
        $categories = $this->getCategoriesWithLimitedProducts();
        
        // Get trending categories for tabs
        $trendingCategories = CategoryModel::where('status', 1)
                             ->orderBy('created_at', 'desc')
                             ->limit(4) // Limiting to 4 categories for tabs
                             ->get();
        
        // Get all trending products
        $trendyAllProducts = ProductModel::where('status', 'in_stock')
                            ->orderBy('created_at', 'desc')
                            ->limit(8)
                            ->get();
                            
        // Transform product data to match view expectations
        $trendyAllProducts->transform(function($product) {
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
            
            return $product;
        });
        
        // Get trending products for each category
        $trendyCategoryProducts = [];
        
        foreach ($trendingCategories as $category) {
            $categoryProducts = ProductModel::where('category_id', $category->id)
                              ->where('status', 'in_stock')
                              ->orderBy('created_at', 'desc')
                              ->limit(8)
                              ->get()
                              ->transform(function($product) {
                                  $product->title = $product->name;
                                  $product->price = $product->new_price;
                                  $product->old_price = $product->old_price;
                                  
                                  if ($product->old_price && $product->old_price > $product->new_price) {
                                      $discount = (($product->old_price - $product->new_price) / $product->old_price) * 100;
                                      $product->discount_percentage = round($discount);
                                  } else {
                                      $product->discount_percentage = 0;
                                  }
                                  
                                  return $product;
                              });
                              
            $trendyCategoryProducts[$category->id] = $categoryProducts;
        }
                                
        return view('home', compact(
            'categories', 
            'trendingCategories',
            'trendyAllProducts', 
            'trendyCategoryProducts'
        ));
    }
    
    /**
     * Search for products
     */
    public function search(Request $request)
    {
        $categories = $this->getCategoriesWithLimitedProducts();
        $query = $request->input('query');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        // Search for products
        $products = ProductModel::search($query)
                    ->where('status', 'in_stock')
                    ->paginate(12);
        
        // Transform products to match view expectations
        $transformedProducts = $products->getCollection()->transform(function($product) {
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
            
            return $product;
        });
        
        // Put the transformed collection back into the paginator
        $products->setCollection($transformedProducts);
        
        // Get sidebar data for filters
        $sidebar_categories = CategoryModel::where('status', 1)->get();
        $sizes = ProductModel::distinct()->whereNotNull('size')->pluck('size');
        $colors = ProductModel::distinct()->whereNotNull('color')->pluck('color');
        $brands = ProductModel::distinct()->whereNotNull('brand')->pluck('brand');
            
        // Get price range
        $priceRange = [
            'min' => ProductModel::min('new_price') ?: 0,
            'max' => ProductModel::max('new_price') ?: 10000
        ];
        
        // Set search term to highlight in the view
        $searchTerm = $query;
        
        // Return the same view as product list but with search results
        return view('products.list', compact(
            'products', 
            'categories', 
            'sidebar_categories', 
            'sizes', 
            'colors', 
            'brands', 
            'priceRange',
            'searchTerm'
        ));
    }
    
    public function productDetail($id)
    {
        $categories = $this->getCategoriesWithLimitedProducts();
        $product = ProductModel::findOrFail($id);
        return view('products.detail', compact('product', 'categories'));
    }
    
    public function categoryProducts($id)
    {
        $categories = $this->getCategoriesWithLimitedProducts();
        $category = CategoryModel::findOrFail($id);
        $products = ProductModel::where('category_id', $id)
                    ->where('status', 'in_stock')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
                    
        return view('products.category', compact('category', 'products', 'categories'));
    }
    
    /**
     * Get all active categories with exactly 3 products each
     */
    private function getCategoriesWithLimitedProducts()
    {
        $categories = CategoryModel::where('status', 1)->get();
        
        foreach ($categories as $category) {
            $category->limitedProducts = ProductModel::where('category_id', $category->id)
                                           ->where('status', 'in_stock')
                                           ->orderBy('created_at', 'desc')
                                           ->limit(3)
                                           ->get();
        }
        
        return $categories;
    }
}
