<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{
    /**
     * Display a list of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
                  
        // Get recent reviews for the sidebar
        $recentReviews = \App\Models\ProductReviewModel::where('user_id', auth()->id())
                        ->with('product')
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
        
        return view('orders.index', compact('orders', 'recentReviews'));
    }
    
    /**
     * Display the details of a specific order.
     */
    public function show($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
                    
            $orderItems = OrderItem::where('order_id', $order->id)
                        ->with('product')
                        ->get();
                        
            $statusHistory = $order->statusHistory()
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
            return view('orders.show', compact('order', 'orderItems', 'statusHistory'));
        } catch (\Exception $e) {
            \Log::error('Error viewing order: ' . $e->getMessage());
            return redirect()->route('orders.index')
                ->with('error', 'There was a problem loading the order details. Please try again.');
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'display_name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Check current password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])
                            ->withInput()
                            ->with('active_tab', 'account'); // This will indicate which tab should be active
            }
        }
        
        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            try {
                // Delete the old profile picture if it exists
                if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                    unlink(public_path($user->profile_picture));
                }
                
                // Generate a unique filename
                $imageName = 'profile_' . time() . '_' . $user->id . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                
                // Move the uploaded file to public directory
                $request->file('profile_picture')->move(public_path('uploads/profile_pictures'), $imageName);
                
                // Save the path relative to public directory
                $user->profile_picture = 'uploads/profile_pictures/' . $imageName;
                
                // Log the image path for debugging
                Log::info('Profile picture uploaded successfully');
                Log::info('Profile picture path: ' . $user->profile_picture);
            } catch (\Exception $e) {
                Log::error('Error uploading profile picture: ' . $e->getMessage());
                return back()->withErrors(['profile_picture' => 'There was an error uploading your profile picture. Please try again.'])
                            ->withInput()
                            ->with('active_tab', 'account');
            }
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully!')
                    ->with('active_tab', 'account');
    }
} 