@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email, click the button below to request another.</p>

                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 