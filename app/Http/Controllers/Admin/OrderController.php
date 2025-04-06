<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function list()
    {
        $orders = Order::with(['user', 'address'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
        return view('admin.orders.list', compact('orders'));
    }
    
    /**
     * Show the details of a specific order.
     */
    public function detail($id)
    {
        $order = Order::with(['user', 'address'])->findOrFail($id);
        $orderItems = OrderItem::where('order_id', $order->id)
                    ->with('product')
                    ->get();
        $statusHistory = OrderStatusHistory::where('order_id', $order->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('admin.orders.detail', compact('order', 'orderItems', 'statusHistory'));
    }
    
    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,shipped,in_transit,delivered,cancelled',
            'comment' => 'nullable|string|max:255',
        ]);
        
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        // Only send notification if status actually changed
        $statusChanged = $oldStatus !== $newStatus;
        
        // Update order status
        $order->status = $newStatus;
        $order->save();
        
        // Comment for status history
        $comment = $request->comment ?? "Order status changed from {$oldStatus} to {$newStatus}";
        
        // Record status change in history
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'comment' => $comment,
            'created_by_id' => auth()->id(),
            'created_at' => now()
        ]);
        
        // Send email notification to customer if status changed
        if ($statusChanged && $order->user && $order->user->email) {
            try {
                // If status is delivered, preload relationships needed for the receipt
                if ($newStatus === 'delivered') {
                    $order->load(['user', 'address', 'orderItems.product']);
                }
                
                Mail::to($order->user->email)
                    ->send(new OrderStatusUpdated($order, $request->comment));
                
                return redirect()->back()->with('success', 'Order status updated and notification email sent to customer.');
            } catch (\Exception $e) {
                \Log::error('Failed to send order status email: ' . $e->getMessage());
                return redirect()->back()->with('success', 'Order status updated but failed to send notification email.');
            }
        }
        
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
} 