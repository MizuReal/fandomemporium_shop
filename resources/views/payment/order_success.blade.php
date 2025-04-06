@extends('layouts.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order Complete<span>Thank You!</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.list') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Complete</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="icon-box">
                        <i class="icon-check" style="font-size: 5rem; color: #28a745; margin-bottom: 2rem;"></i>
                        <h3 class="icon-box-title">Thank you!</h3>
                        <p>Your order has been received</p>
                        
                        @if(isset($orderNumber))
                            <p class="lead">Order Number: <strong>{{ $orderNumber }}</strong></p>
                            <p>You can track your order status in <a href="{{ route('orders.index') }}">My Orders</a> section.</p>
                        @endif
                        
                        <div class="mt-4">
                            <a href="{{ route('products.list') }}" class="btn btn-outline-primary-2">
                                <span>CONTINUE SHOPPING</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                            
                            @if(isset($orderNumber))
                                <a href="{{ route('orders.show', $orderNumber) }}" class="btn btn-primary ml-3">
                                    <span>VIEW ORDER DETAILS</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection 