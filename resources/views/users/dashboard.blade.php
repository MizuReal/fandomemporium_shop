@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<main class="main">
        	<div class="page-header text-center" style="background-image: url('{{ asset('home/assets/images/page-header-bg.jpg') }}')">
        		<div class="container">
        			<h1 class="page-title">My Account</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Account</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">
	                		<aside class="col-md-4 col-lg-3">
	                			<ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
								    <li class="nav-item">
								        <a class="nav-link {{ session('active_tab') != 'account' && session('active_tab') != 'orders' && session('active_tab') != 'address' ? 'active' : '' }}" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="{{ session('active_tab') ? 'false' : 'true' }}">Dashboard</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link {{ session('active_tab') == 'orders' ? 'active' : '' }}" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="{{ session('active_tab') == 'orders' ? 'true' : 'false' }}">Orders</a>
								    </li>
								  
								    <li class="nav-item">
								        <a class="nav-link {{ session('active_tab') == 'address' ? 'active' : '' }}" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="{{ session('active_tab') == 'address' ? 'true' : 'false' }}">Addresses</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link {{ session('active_tab') == 'account' ? 'active' : '' }}" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="{{ session('active_tab') == 'account' ? 'true' : 'false' }}">Account Details</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ route('user.logout') }}">Sign Out</a>
								    </li>
								</ul>
	                		</aside><!-- End .col-lg-3 -->

	                		<div class="col-md-8 col-lg-9">
	                			<div class="tab-content">
								    <div class="tab-pane fade {{ session('active_tab') != 'account' && session('active_tab') != 'orders' && session('active_tab') != 'address' ? 'show active' : '' }}" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
								    	<p>Hello <span class="font-weight-normal text-dark">{{ Auth::user()->name }}</span> (not <span class="font-weight-normal text-dark">{{ Auth::user()->name }}</span>? <a href="{{ route('user.logout') }}">Log out</a>)
								    	<br>
								    	From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade {{ session('active_tab') == 'orders' ? 'show active' : '' }}" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
								    	@if(count(Auth::user()->orders) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-cart table-mobile">
                                                <thead>
                                                    <tr>
                                                        <th>Order #</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach(Auth::user()->orders as $order)
                                                    <tr>
                                                        <td>{{ $order->order_number }}</td>
                                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                        <td><span class="badge badge-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($order->status) }}</span></td>
                                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                        <td><a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-primary-2">View</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
								    	<p>No order has been made yet.</p>
								    	<a href="{{ route('product.list') }}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                        @endif
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
								    	<p>No downloads available yet.</p>
								    	<a href="{{ route('product.list') }}" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade {{ session('active_tab') == 'address' ? 'show active' : '' }}" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
								    	<p>The following addresses will be used on the checkout page by default.</p>

								    	<div class="row">
								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Billing Address</h3><!-- End .card-title -->
                                                        
                                                        @php
                                                        $defaultBillingAddress = Auth::user()->addresses()->where('is_default', 1)->first();
                                                        @endphp
                                                        
                                                        @if($defaultBillingAddress)
														<p>{{ $defaultBillingAddress->full_name }}<br>
														{{ $defaultBillingAddress->address_line1 }}<br>
                                                        @if($defaultBillingAddress->address_line2)
                                                        {{ $defaultBillingAddress->address_line2 }}<br>
                                                        @endif
														{{ $defaultBillingAddress->city }}, {{ $defaultBillingAddress->state }} {{ $defaultBillingAddress->postal_code }}<br>
														{{ $defaultBillingAddress->country }}<br>
														{{ $defaultBillingAddress->phone }}<br>
														<a href="{{ route('checkout') }}">Edit <i class="icon-edit"></i></a></p>
                                                        @else
                                                        <p>You have not set up a billing address yet.<br>
														<a href="{{ route('checkout') }}">Add address <i class="icon-edit"></i></a></p>
                                                        @endif
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->

								    		<div class="col-lg-6">
								    			<div class="card card-dashboard">
								    				<div class="card-body">
								    					<h3 class="card-title">Shipping Address</h3><!-- End .card-title -->
                                                        
                                                        @php
                                                        $shippingAddresses = Auth::user()->addresses()->where('is_default', 0)->first();
                                                        @endphp
                                                        
                                                        @if($shippingAddresses)
														<p>{{ $shippingAddresses->full_name }}<br>
														{{ $shippingAddresses->address_line1 }}<br>
                                                        @if($shippingAddresses->address_line2)
                                                        {{ $shippingAddresses->address_line2 }}<br>
                                                        @endif
														{{ $shippingAddresses->city }}, {{ $shippingAddresses->state }} {{ $shippingAddresses->postal_code }}<br>
														{{ $shippingAddresses->country }}<br>
														{{ $shippingAddresses->phone }}<br>
														<a href="{{ route('checkout') }}">Edit <i class="icon-edit"></i></a></p>
                                                        @else
														<p>You have not set up this type of address yet.<br>
														<a href="{{ route('checkout') }}">Add address <i class="icon-edit"></i></a></p>
                                                        @endif
								    				</div><!-- End .card-body -->
								    			</div><!-- End .card-dashboard -->
								    		</div><!-- End .col-lg-6 -->
								    	</div><!-- End .row -->
								    </div><!-- .End .tab-pane -->

								    <div class="tab-pane fade {{ session('active_tab') == 'account' ? 'show active' : '' }}" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
								    	<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                            @endif
                                            
                                            @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
			                				<div class="row">
			                					<div class="col-sm-6">
			                						<label>Name *</label>
			                						<input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
			                					</div><!-- End .col-sm-6 -->

			                					<div class="col-sm-6">
			                						<label>Profile Picture</label>
                                                    <input type="file" class="form-control" name="profile_picture">
                                                    @if(Auth::user()->profile_picture)
                                                    <div class="mt-2">
                                                        <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" class="img-thumbnail" style="max-width: 100px;">
                                                        <p class="small text-muted mt-1">Current profile picture</p>
                                                    </div>
                                                    @endif
			                					</div><!-- End .col-sm-6 -->
			                				</div><!-- End .row -->

		            						<label>Display Name *</label>
		            						<input type="text" class="form-control" name="display_name" value="{{ old('display_name', Auth::user()->name) }}" required>
		            						<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>

		                					<label>Email address *</label>
		        							<input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>

		            						<label>Current password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control" name="current_password">
                                            @if($errors->has('current_password'))
                                            <small class="text-danger">{{ $errors->first('current_password') }}</small>
                                            @endif

		            						<label>New password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control" name="password">

		            						<label>Confirm new password</label>
		            						<input type="password" class="form-control mb-2" name="password_confirmation">

		                					<button type="submit" class="btn btn-outline-primary-2">
			                					<span>SAVE CHANGES</span>
			            						<i class="icon-long-arrow-right"></i>
			                				</button>
			                			</form>
								    </div><!-- .End .tab-pane -->
								</div>
	                		</div><!-- End .col-lg-9 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Activate tab based on session data
        @if(session('active_tab'))
            $('#tab-{{ session('active_tab') }}-link').tab('show');
        @endif
        
        // Prevent any modals from showing when we're in the account section
        $('#signin-modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
    });
</script>
@endsection