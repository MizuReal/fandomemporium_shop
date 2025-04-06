@extends('layouts.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order Details<span>{{ $order->order_number }}</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->order_number }}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-dashboard mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Order Information</h3>
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Date:</strong> {{ $order->created_at ? $order->created_at->format('F d, Y h:i A') : 'N/A' }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                            @if($order->notes)
                                <p><strong>Order Notes:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card card-dashboard mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Order Items</h3>
                            <div class="table-responsive">
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderItems as $item)
                                            <tr>
                                                <td class="product-col">
                                                    <div class="product">
                                                        @if($item->product && $item->product->main_image)
                                                            <figure class="product-media">
                                                                <a href="{{ route('products.detail', $item->product_id) }}">
                                                                    <img src="{{ asset($item->product->main_image) }}" alt="{{ $item->product ? $item->product->name : 'Product Image' }}">
                                                                </a>
                                                            </figure>
                                                        @endif
                                                        <h4 class="product-title">
                                                            @if($item->product)
                                                                <a href="{{ route('products.detail', $item->product_id) }}">{{ $item->product->name }}</a>
                                                            @else
                                                                Product no longer available
                                                            @endif
                                                            @if($item->size || $item->color)
                                                                <small>
                                                                    @if($item->color)
                                                                        (Color: {{ $item->color }}
                                                                    @endif
                                                                    
                                                                    @if($item->size)
                                                                        @if($item->color)
                                                                            , 
                                                                        @else
                                                                            (
                                                                        @endif
                                                                        Size: {{ $item->size }})
                                                                    @else
                                                                        )
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </td>
                                                <td class="price-col">₱{{ number_format($item->price, 2) }}</td>
                                                <td class="quantity-col">
                                                    <div class="cart-product-quantity">
                                                        {{ $item->quantity }}
                                                    </div>
                                                </td>
                                                <td class="total-col">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    @if(count($statusHistory) > 0)
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <h3 class="card-title">Order Status History</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($statusHistory as $status)
                                                <tr>
                                                    <td>
                                                        @if($status->created_at)
                                                            {{ $status->created_at->format('M d, Y h:i A') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $status->status == 'delivered' ? 'success' : ($status->status == 'cancelled' ? 'danger' : 'info') }}">
                                                            {{ ucfirst($status->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $status->comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <aside class="col-lg-4">
                    <div class="card card-dashboard mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Shipping Address</h3>
                            @if($order->address)
                                <p>{{ $order->address->full_name }}</p>
                                <p>{{ $order->address->address_line1 }}</p>
                                @if($order->address->address_line2)
                                    <p>{{ $order->address->address_line2 }}</p>
                                @endif
                                <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
                                <p>{{ $order->address->country }}</p>
                                <p>{{ $order->address->phone }}</p>
                            @else
                                <p>No shipping address information available.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <h3 class="card-title">Order Summary</h3>
                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping:</td>
                                        <td>Free shipping</td>
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary-2 btn-order btn-block">
                                <span class="btn-text">Back to My Orders</span>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</main>

@endsection 