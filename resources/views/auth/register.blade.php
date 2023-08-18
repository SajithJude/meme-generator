@extends('layouts.web')
@section('content')
<style>
    a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }
    .login {
        color: #3f3f3f;
        text-decoration: none;
    }
    .login:hover {
        color: white;
        text-decoration: none;
    }
</style>
<div class="container">
    <div class="row">
        <div class="h-100 d-flex align-items-center justify-content-center mt-5 mb-login">
            <div class="login-area" style="width: 612px;">
                <h1>Sign Up</h1>
                <span>Get started by filling up details below</span>
                <div class="login-option">
                    <a href="{{url('login/google')}}" class="login mb-3" style="line-height: 27px; padding: 13px 0;"><img src="{{url('images/')}}/google.svg"> Sign up with Google </a>
                    <a href="{{url('login/facebook')}}" class="login mb-2" style="line-height: 27px; padding: 13px 0;"><img src="{{url('images/')}}/fb.svg"> Sign up with Facebook </a>
                </div>
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form id="registerForm" method="POST"
                    action="{{ route('register') }}?free=<?= isset($_GET['free'])?1:0 ?>">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">First Name</label>
                                <input type="text" class="form-control f-img" name="first_name" required="required" placeholder="Enter first name">
                                <img src="{{url('images/')}}/person.svg" alt="">
                                <div class="alert alert-danger mt-1 mb-1 firstNameError" style="display: none;">Please enter first name</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                <input type="text" class="form-control f-img" name="last_name" required="required" placeholder="Enter last name">
                                <img src="{{url('images/')}}/person.svg" alt="">
                                <div class="alert alert-danger mt-1 mb-1 lastNameError" style="display: none;">Please enter last name</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                <input type="text" class="form-control f-img" name="phone_number" required="required" placeholder="Enter phone number">
                                <img src="{{url('images/')}}/call.svg" alt="">
                                <div class="alert alert-danger mt-1 mb-1 phoneNumberError" style="display: none;">Please enter phone number</div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">Email id</label>
                                <input type="email" class="form-control" name="email" required="required" placeholder="Enter email id">
                                <img src="{{url('images/')}}//mail.svg" alt="">
                                <div class="alert alert-danger mt-1 mb-1 emailError" style="display: none;">Please enter email</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required="required" placeholder="Enter password">
                                <div class="alert alert-danger mt-1 mb-1 passwordError" style="display: none;">Please enter password</div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required="required" placeholder="Confirm Password">
                                <div class="alert alert-danger mt-1 mb-1 cpasswordError" style="display: none;">Please enter confirmdf password</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="signup-field">
                                <label for="exampleInputEmail1" class="form-label">City</label>
                                <input type="text" class="form-control f-img" name="city" placeholder="City">
                                <img src="{{url('images/')}}/location_on.svg" alt="">
                                <div class="alert alert-danger mt-1 mb-1 cityError" style="display: none;">Please enter city</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="login-m registerBtn">Sign up</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection