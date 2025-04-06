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
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Orders Management</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order #</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $order->order_number }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $order->user->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $order->user->email }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $order->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-sm font-weight-bold">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge bg-{{ getStatusColor($order->status) }} px-2 py-1 text-white" style="min-width: 80px;">
                                            {{ formatStatus($order->status) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="btn btn-link text-dark px-3 mb-0">
                                            <i class="fas fa-eye text-dark me-2" aria-hidden="true"></i>View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
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