@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Reviews Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Message Display -->
                @include('admin.layouts._message')
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Reviews</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th style="width: 25%;">Product</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Date</th>
                                    <th style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($reviews) && $reviews->count() > 0)
                                    @foreach($reviews as $review)
                                        <tr>
                                            <td>{{ $review->id }}</td>
                                            <td>
                                                @if($review->product)
                                                    <div class="product-row">
                                                        <div class="product-image">
                                                            @if($review->product->main_image)
                                                                <img src="{{ asset($review->product->main_image) }}" alt="{{ $review->product->name }}" width="60" height="60" class="img-thumbnail">
                                                            @elseif($review->product->image1)
                                                                <img src="{{ asset($review->product->image1) }}" alt="{{ $review->product->name }}" width="60" height="60" class="img-thumbnail">
                                                            @elseif($review->product->image2)
                                                                <img src="{{ asset($review->product->image2) }}" alt="{{ $review->product->name }}" width="60" height="60" class="img-thumbnail">
                                                            @else
                                                                <img src="{{ asset('assets/images/products/placeholder.jpg') }}" alt="{{ $review->product->name }}" width="60" height="60" class="img-thumbnail">
                                                            @endif
                                                        </div>
                                                        <div class="product-info">
                                                            <div class="product-name font-weight-bold">{{ $review->product->name }}</div>
                                                            <div class="product-price text-muted small mt-1">₱{{ number_format($review->product->new_price, 2) }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Product not available</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($review->createdBy)
                                                    <div class="user-info">
                                                        <div class="user-name">{{ $review->createdBy->name }}</div>
                                                        <div class="user-email text-muted small">{{ $review->createdBy->email }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Anonymous</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-{{ $review->rating >= 4 ? 'success' : ($review->rating >= 3 ? 'warning' : 'danger') }} mr-2">
                                                        {{ $review->rating }}
                                                    </span>
                                                    <div class="ratings-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star{{ $i <= $review->rating ? ' text-warning' : ' text-muted' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="review-content">
                                                    {{ $review->review }}
                                                </div>
                                            </td>
                                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a onclick="return confirm('Are you sure you want to delete this review?')" href="{{ url('admin/reviews/delete/'.$review->id) }}" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No reviews found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $reviews->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('style')
<style>
    .ratings-stars {
        display: inline-flex;
    }
    
    .product-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-image img {
        object-fit: cover;
        border-radius: 4px;
    }

    .product-info {
        max-width: 200px;
    }
    
    .review-content {
        max-height: 100px;
        overflow-y: auto;
        white-space: pre-line;
        font-size: 0.9rem;
        padding: 5px;
        background-color: #f9f9f9;
        border-radius: 4px;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    .product-name {
        font-size: 14px;
        line-height: 1.3;
    }
</style>
@endsection 