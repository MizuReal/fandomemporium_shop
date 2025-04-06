<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show the checkout page with cart contents
     */
    public function checkout()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to continue with checkout.')->with('login_modal', true);
        }
        
        // Get cart contents
        $cartContents = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        // If cart is empty, redirect to products page
        if ($cartContents->isEmpty()) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty. Please add products before checkout.');
        }
        
        return view('payment.checkout', compact('cartContents', 'cartTotal'));
    }
    
    /**
     * Process the payment
     */
    public function process(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'Please login to continue with checkout.')->with('login_modal', true);
        }
        
        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        
        // Get cart contents
        $cartContents = Cart::getContent();
        $cartTotal = Cart::getTotal();
        
        // If cart is empty, redirect to products page
        if ($cartContents->isEmpty()) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty. Please add products before checkout.');
        }
        
        try {
            // Start a database transaction
            DB::beginTransaction();
            
            // 1. Create or update address
            $fullName = $request->first_name . ' ' . $request->last_name;
            $address = Address::create([
                'user_id' => auth()->id(),
                'full_name' => $fullName,
                'phone' => $request->phone,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2 ?? null,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'is_default' => 1 // Make this the default address
            ]);
            
            // If this is set as default, unset any other default addresses
            if ($address->is_default) {
                Address::where('user_id', auth()->id())
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => 0]);
            }
            
            // 2. Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'address_id' => $address->id,
                'total_amount' => $cartTotal,
                'status' => 'processing', // As requested, use 'processing' for COD
                'payment_method' => 'Cash on Delivery',
                'notes' => $request->notes ?? null
            ]);
            
            // 3. Create order items
            foreach ($cartContents as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'size' => $item->attributes['options']['size'] ?? null,
                    'color' => $item->attributes['options']['color'] ?? null
                ]);
                
                // Optionally, you could update product inventory here
                // $product = ProductModel::find($item->id);
                // $product->quantity -= $item->quantity;
                // $product->save();
            }
            
            // 4. Record the order status change
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'processing',
                'comment' => 'Order placed successfully',
                'created_by_id' => auth()->id(),
                'created_at' => now()
            ]);
            
            // Commit the transaction
            DB::commit();
            
            // Clear the cart after successful order
            Cart::clear();
            
            // Redirect to success page with order number
            return redirect()->route('payment.success', ['orderNumber' => $order->order_number]);
            
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollBack();
            
            // Log the error
            \Log::error('Order placement failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'There was a problem processing your order. Please try again or contact customer support.');
        }
    }
    
    /**
     * Generate a unique order number
     */
    private function generateOrderNumber()
    {
        // Format: FE-YEAR-RANDOM (e.g., FE-2025-ABC123)
        $year = date('Y');
        $random = strtoupper(Str::random(6));
        $orderNumber = "FE-{$year}-{$random}";
        
        // Check if order number already exists
        $exists = Order::where('order_number', $orderNumber)->exists();
        
        // If it exists, generate a new one
        if ($exists) {
            return $this->generateOrderNumber();
        }
        
        return $orderNumber;
    }

    /**
     * Show the order success page
     */
    public function success(Request $request)
    {
        $orderNumber = $request->orderNumber;
        return view('payment.order_success', compact('orderNumber'));
    }
} 