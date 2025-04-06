@extends('layouts.app')
@section('content')

<style>
    .product-title {
        margin-bottom: 15px;
    }
    .product-option {
        margin-top: 8px;
        display: block;
    }
    .product-col .product {
        padding: 15px 0;
    }
    .product-detail-line {
        line-height: 1.6;
    }
</style>

<div class="page-content">
    <div class="cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <table class="table table-cart table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($cartContents->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Your cart is empty</p>
                                        <a href="{{ route('products.list') }}" class="btn btn-outline-primary-2"><span>CONTINUE SHOPPING</span><i class="icon-long-arrow-right"></i></a>
                                    </td>
                                </tr>
                            @else
                                @foreach($cartContents as $item)
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{ route('products.detail', $item->id) }}">
                                                    @if(isset($item->attributes['image']))
                                                        <img src="{{ asset($item->attributes['image']) }}" alt="{{ $item->name }}">
                                                    @else
                                                        <img src="{{ asset('home/assets/images/products/placeholder.jpg') }}" alt="{{ $item->name }}">
                                                    @endif
                                                </a>
                                            </figure>

                                            <div class="product-detail-line">
                                                <h3 class="product-title">
                                                    <a href="{{ route('products.detail', $item->id) }}">{{ $item->name }}</a>
                                                </h3><!-- End .product-title -->
                                                
                                                @if(isset($item->attributes['options']))
                                                    @if(isset($item->attributes['options']['color']))
                                                    <div class="product-option">
                                                        <span><strong>Color:</strong> {{ $item->attributes['options']['color'] }}</span>
                                                    </div>
                                                    @endif
                                                    
                                                    @if(isset($item->attributes['options']['size']))
                                                    <div class="product-option">
                                                        <span><strong>Size:</strong> {{ $item->attributes['options']['size'] }}</span>
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="quantity-col">
                                        <form action="{{ route('cart.update') }}" method="POST" class="update-cart-form">
                                            @csrf
                                            <input type="hidden" name="rowId" value="{{ $item->id }}">
                                            <div class="cart-product-quantity">
                                                <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1" max="10" step="1" data-decimals="0" required onchange="this.form.submit()">
                                            </div><!-- End .cart-product-quantity -->
                                        </form>
                                    </td>
                                    <td class="total-col">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    <td class="remove-col">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="rowId" value="{{ $item->id }}">
                                            <button type="submit" class="btn-remove"><i class="icon-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table><!-- End .table table-wishlist -->

                    <div class="cart-bottom">
                        <a href="{{ route('cart.clear') }}" class="btn btn-outline-dark-2"><span>CLEAR CART</span><i class="icon-refresh"></i></a>
                    </div><!-- End .cart-bottom -->
                </div><!-- End .col-lg-9 -->
                <div class="col-lg-3">
                    <div class="summary summary-cart">
                        <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                        <table class="table table-summary">
                            <tbody>
                                <tr class="summary-subtotal">
                                    <td>Subtotal:</td>
                                    <td>₱{{ number_format($cartTotal, 2) }}</td>
                                </tr><!-- End .summary-subtotal -->
                                <tr class="summary-shipping">
                                    <td>Shipping:</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr class="summary-shipping-row">
                                    <td>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                        </div><!-- End .custom-control -->
                                    </td>
                                    <td>₱0.00</td>
                                </tr><!-- End .summary-shipping-row -->

                                <tr class="summary-total">
                                    <td>Total:</td>
                                    <td>₱{{ number_format($cartTotal, 2) }}</td>
                                </tr><!-- End .summary-total -->
                            </tbody>
                        </table><!-- End .table table-summary -->

                        @if(auth()->check())
                            <a href="{{ route('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        @else
                            <a href="javascript:void(0)" onclick="$('#signin-modal').modal('show'); $('#signin-tab').tab('show');" class="btn btn-outline-primary-2 btn-order btn-block">LOGIN TO CHECKOUT</a>
                        @endif
                    </div><!-- End .summary -->

                    <a href="{{ route('products.list') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                </div><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cart -->
</div><!-- End .page-content -->

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Show success/error message if exists
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
@endsection 