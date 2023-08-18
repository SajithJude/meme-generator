@extends('layouts.landing')
@section('content')
<!-- <div class="container"> -->

<div class="mt-4 flex items-center justify-between">
    <!--<form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form> -->

    <!-- <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Log Out') }}
                </button>
            </form> -->
    <!-- </nav> -->
    <!-- </div> -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3 text-center">
                <div class="login-area">
                    <img class="mx-auto d-block" src="{{url('images/')}}/Mail-box.svg" alt=""
                        style="margin-bottom: 50px;">
                    @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600" style="color:green;">
                        {{ __('A new verification link has been sent to the email address you provided during
                        registration.') }}
                    </div>
                    @endif

                    <h3 class="h3_heading mb-5">Verify your Email</h3>
                    <p class="mb-5">We’ve sent an email to <strong>{{Auth::user()->email}}</strong> to verify your
                        email<br />
                        address and activate your account. The link in the email will expire in 24 hours.</p>
                    <p class="mb-5">
                        <a href="{{ route('verification.send') }}">Click here</a> to resend the email verification.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection