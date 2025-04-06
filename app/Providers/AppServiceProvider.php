<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all views
        View::composer('*', function ($view) {
            if (!$view->offsetExists('categories')) {
                try {
                    $categories = CategoryModel::where('status', 1)->get();
                    
                    foreach ($categories as $category) {
                        // Make sure limitedProducts is always initialized
                        if (!isset($category->limitedProducts)) {
                            $category->limitedProducts = ProductModel::where('category_id', $category->id)
                                                        ->where('status', 'in_stock')
                                                        ->orderBy('created_at', 'desc')
                                                        ->limit(3)
                                                        ->get();
                        }
                    }
                    
                    $view->with('categories', $categories);
                } catch (\Exception $e) {
                    \Log::error('Error loading categories in view composer: ' . $e->getMessage());
                    $view->with('categories', collect([]));
                }
            } else {
                // If categories exist but limitedProducts are not loaded, load them
                $categories = $view->getData()['categories'];
                if (is_object($categories) && method_exists($categories, 'isNotEmpty') && $categories->isNotEmpty()) {
                    foreach ($categories as $category) {
                        if (!isset($category->limitedProducts) || (is_object($category->limitedProducts) && method_exists($category->limitedProducts, 'isEmpty') && $category->limitedProducts->isEmpty())) {
                            $category->limitedProducts = ProductModel::where('category_id', $category->id)
                                                      ->where('status', 'in_stock')
                                                      ->orderBy('created_at', 'desc')
                                                      ->limit(3)
                                                      ->get();
                        }
                    }
                }
            }
        });
    }
}
