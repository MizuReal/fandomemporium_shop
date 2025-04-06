@extends('admin.layouts.app')

@section('content')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        border: none !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
    }
    
    .badge {
        padding: 0.35em 0.65em;
    }
    
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Order Details: {{ $order->order_number }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.orders.list') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Orders
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Shipping Address</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Name:</strong> {{ $order->address->full_name }}</p>
                                    <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
                                    <p><strong>Address:</strong> {{ $order->address->address_line1 }}</p>
                                    @if($order->address->address_line2)
                                        <p>{{ $order->address->address_line2 }}</p>
                                    @endif
                                    <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
                                    <p>{{ $order->address->country }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Summary</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                                    <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                                    <p>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ getStatusColor($order->status) }} px-2 py-1 text-white" style="min-width: 80px;">
                                            {{ formatStatus($order->status) }}
                                        </span>
                                    </p>
                                    @if($order->notes)
                                        <p><strong>Notes:</strong> {{ $order->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Update Status</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold">Order Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" style="border-radius: 6px; padding: 8px;">
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="in_transit" {{ $order->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="comment" class="form-label fw-bold">Status Comment (Optional)</label>
                                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3" style="border-radius: 6px; padding: 8px;" placeholder="Add a comment about this status change..."></textarea>
                                            @error('comment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary px-4 py-2">Update Status</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Items</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orderItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product && $item->product->main_image)
                                                                <img src="{{ asset($item->product->main_image) }}" class="avatar avatar-sm me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                            @endif
                                                            <div class="d-flex flex-column">
                                                                <h6 class="mb-0 text-sm">{{ $item->product ? $item->product->name : 'Product Unavailable' }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->size ?? 'N/A' }}</td>
                                                    <td>{{ $item->color ?? 'N/A' }}</td>
                                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Status History</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Comment</th>
                                                    <th>Updated By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($statusHistory as $history)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y h:i A') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ getStatusColor($history->status) }} px-2 py-1 text-white" style="min-width: 80px;">
                                                            {{ formatStatus($history->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $history->comment ?? 'No comment' }}</td>
                                                    <td>
                                                        @if($history->createdBy)
                                                            {{ $history->createdBy->name }}
                                                        @else
                                                            System
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Any additional JavaScript can go here
</script>
@endpush

@php
function getStatusColor($status) {
    switch ($status) {
        case 'processing':
            return 'info';
        case 'shipped':
            return 'primary';
        case 'in_transit':
            return 'warning';
        case 'delivered':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

function formatStatus($status) {
    switch ($status) {
        case 'in_transit':
            return 'In Transit';
        default:
            return ucfirst($status);
    }
}
@endphp 