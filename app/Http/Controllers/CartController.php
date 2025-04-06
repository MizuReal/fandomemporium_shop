<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use Cart;

class CartController extends Controller
{
    /**
     * Add an item to the cart
     */
    public function addToCart(Request $request)
    {
        try {
            // Check if user is authenticated, if not, redirect with login modal
            if (!auth()->check()) {
                return redirect()->back()->with('error', 'Please login to add items to your cart.')->with('login_modal', true);
            }
            
            // Validate the request
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Get the product
            $product = ProductModel::findOrFail($request->product_id);
            
            // Check if color and size were provided (if applicable)
            $options = [];
            if ($request->has('color') && $request->color) {
                $options['color'] = $request->color;
            }
            
            if ($request->has('size') && $request->size) {
                $options['size'] = $request->size;
            }
            
            // Add to cart
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->new_price,
                'quantity' => $request->quantity,
                'attributes' => [
                    'image' => $product->main_image,
                    'options' => $options
                ]
            ]);
            
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product to cart: ' . $e->getMessage());
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'rowId' => 'required',
                'quantity' => 'required|integer|min:1',
            ]);
            
            // Update the cart
            Cart::update($request->rowId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ]
            ]);
            
            return redirect()->back()->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update cart: ' . $e->getMessage());
        }
    }

    /**
     * Remove an item from the cart
     */
    public function removeFromCart(Request $request)
    {
        try {
            Cart::remove($request->rowId);
            return redirect()->back()->with('success', 'Item removed from cart!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove item from cart: ' . $e->getMessage());
        }
    }

    /**
     * Clear the entire cart
     */
    public function clearCart()
    {
        try {
            Cart::clear();
            return redirect()->back()->with('success', 'Cart cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear cart: ' . $e->getMessage());
        }
    }

    /**
     * Show the cart page
     */
    public function viewCart()
    {
        $cartContents = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        return view('cart.view', compact('cartContents', 'cartTotal'));
    }

    /**
     * Return cart summary for AJAX requests
     */
    public function getCartSummary()
    {
        $cartContents = Cart::getContent();
        $cartTotal = Cart::getTotal();
        $cartCount = Cart::getTotalQuantity();
        
        return response()->json([
            'count' => $cartCount,
            'total' => $cartTotal,
            'items' => $cartContents
        ]);
    }
}
