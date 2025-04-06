@extends('layouts.app')
@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Checkout<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.list') }}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container">
                        @if($cartContents->isEmpty())
                            <div class="alert alert-info text-center">
                                <p>Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
                                <a href="{{ route('products.list') }}" class="btn btn-outline-primary-2 mt-3"><span>CONTINUE SHOPPING</span><i class="icon-long-arrow-right"></i></a>
                            </div>
                        @else
            			<form action="{{ route('payment.process') }}" method="POST">
                            @csrf
		                	<div class="row">
		                		<div class="col-lg-9">
		                			<h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>First Name *</label>
		                						<input type="text" name="first_name" class="form-control" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Last Name *</label>
		                						<input type="text" name="last_name" class="form-control" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	            						<label>Company Name (Optional)</label>
	            						<input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">

	            						<label>Country *</label>
	            						<input type="text" name="country" class="form-control" value="{{ old('country', auth()->user()->country ?? '') }}" required>

	            						<label>Street address *</label>
	            						<input type="text" name="address_line1" class="form-control" placeholder="House number and Street name" value="{{ old('address_line1', auth()->user()->address_line1 ?? '') }}" required>
	            						<input type="text" name="address_line2" class="form-control" placeholder="Apartments, suite, unit etc..." value="{{ old('address_line2', auth()->user()->address_line2 ?? '') }}">

	            						<div class="row">
		                					<div class="col-sm-6">
		                						<label>Town / City *</label>
		                						<input type="text" name="city" class="form-control" value="{{ old('city', auth()->user()->city ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>State / County *</label>
		                						<input type="text" name="state" class="form-control" value="{{ old('state', auth()->user()->state ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>Postcode / ZIP *</label>
		                						<input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Phone *</label>
		                						<input type="tel" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

                                        <label>Order Notes (Optional)</label>
                                        <textarea name="notes" class="form-control" placeholder="Notes about your order, special delivery instructions, etc.">{{ old('notes') }}</textarea>

	                					<label>Email address *</label>
	        							<input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th>Product</th>
		                							<th>Total</th>
		                						</tr>
		                					</thead>

		                					<tbody>
                                                @foreach($cartContents as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('products.detail', $item->id) }}">
                                                            {{ $item->name }}
                                                            @if(isset($item->attributes['options']))
                                                                <small>
                                                                    @if(isset($item->attributes['options']['color']))
                                                                        (Color: {{ $item->attributes['options']['color'] }}
                                                                    @endif
                                                                    
                                                                    @if(isset($item->attributes['options']['size']))
                                                                        @if(isset($item->attributes['options']['color']))
                                                                            , 
                                                                        @else
                                                                            (
                                                                        @endif
                                                                        Size: {{ $item->attributes['options']['size'] }})
                                                                    @else
                                                                        )
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </a>
                                                        <span class="product-qty"> × {{ $item->quantity }}</span>
                                                    </td>
                                                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                
		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td>₱{{ number_format($cartTotal, 2) }}</td>
		                						</tr><!-- End .summary-subtotal -->
		                						<tr>
		                							<td>Shipping:</td>
		                							<td>Free shipping</td>
		                						</tr>
		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td>₱{{ number_format($cartTotal, 2) }}</td>
		                						</tr><!-- End .summary-total -->
		                					</tbody>
		                				</table><!-- End .table table-summary -->

		                				<div class="accordion-summary" id="accordion-payment">
										    <div class="card">
										        <div class="card-header" id="heading-3">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
										                    Cash on delivery
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-payment">
										            <div class="card-body">Our courier will bring you the order and you will pay for it upon receipt. The payment is made in cash to the courier.</div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->
                                            
                                    

										</div><!-- End .accordion -->

		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">Place Order</span>
		                					<span class="btn-hover-text">Proceed to Checkout</span>
		                				</button>
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			</form>
                        @endif
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
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