@extends('layouts.main')
@section('content')
<style>
    .img-responsive{
        max-width:100%;
        height:auto;
    }
    .inputfile {
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: 1;
        width: 50px;
        height: 50px;
    }
    .inputfile + label {
        font-size: 1.25rem;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        overflow: hidden;
        width: 30px;
        height: 30px;
        pointer-events: none;
        cursor: pointer;
        line-height: 30px;
        text-align: center;
    }
    li.nav-item {
    margin-left: 0;
}
</style>
<?php 
        use App\Models\UserSubscribedPlan;
        $subs=UserSubscribedPlan::join('subscriptions','subscriptions.id','user_subscribed_plans.subscription_id')->where('user_id',Auth::user()->id)->where('is_active',1)->select('subscriptions.plans','user_subscribed_plans.*')->first(); 
        $profilePic = Auth::user()->profile_pic;
        ?>
<div class="container emp-profile ff">
            <!-- <form method="post"> -->
            <!-- {{-- @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif --}}

            {{-- @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif --}} -->
            <div class="row mt-5 mh-100">
                    <div class="col-md-2">
                        <form id="editProfileForm" action="{{url('editprofile')}}" method="post" enctype="multipart/form-data">
                        
                        <div class="image_container" style="width: 150px;height: 150px;margin: auto; position: relative;">
                            <img class="profile-pic" src="{{ isset($profilePic) ? asset('profile_images/'.$profilePic) : asset('images/no_avatar.png') }}" alt="profile-pic" style="width: 100% !important; height: 100% !important; border-radius: 100%; object-fit: cover; object-position: top;">
                            <div class="image_inner" style="background-color: #ffffff; width: 30px; height: 30px;border-radius: 100%; position: absolute; bottom: 0; right:19px;border:1px solid">
                                <input class="inputfile" type="file" name="pic" accept="image/*">
                                <label><i class="fa fa-pencil"></i></label>
                            </div>
                       </div>
                       
                        <!-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" width="200px" class="rounded-circle mx-auto d-block" alt="avatar"> -->
                    <br/>
                    <div class="profile-work text-center">
                        <h5 class="cfhp">
                                        {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                                    </h5>
                                    <h6 class="cfhpd">
                                        @if ($subs != null)
                                         {{strtoupper($subs->plans)}}

                                        
                                        @endif
                                    </h6>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; {{ucfirst(Auth::user()->city)}}</p>
                        </div> 
                    </div>
                    <div class="col-md-6 offset-md-2">
                        <div class="profile-head">
                                   
                            <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{($aboutUs ? '':'active')}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Contact Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{($aboutUs ? 'active':'')}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">About</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content profile-tab" id="myTabContent">
                                <div class="tab-pane fade {{($aboutUs ? '':'show active')}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                               
                                    @csrf
                                            <input type="hidden"  value=" {{Auth::user()->id}}" name="id">
                                            <div class="row mt-5">
                                                <div class="col-lg-5">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">First Name</label>
                                                            <input type="text" class="form-control f-img" name="first_name" required="required"  value=" {{Auth::user()->first_name}}" 

                                                            placeholder="Enter first name">
                                                        <img src="{{url('images/')}}/person.svg" alt="">
                                                        <div class="alert alert-danger mt-1 mb-1 firstNameError" style="display: none;">Please enter first name</div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 offset-lg-2">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control f-img" name="last_name" required="required" placeholder="Enter last name" value=" {{Auth::user()->last_name}}">
                                                        <img src="{{url('images/')}}/person.svg" alt="">
                                                        <div class="alert alert-danger mt-1 mb-1 lastNameError" style="display: none;">Please enter last name</div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control f-img" name="phone_number"  placeholder="Enter phone number" value="{{Auth::user()->phone_number}}">
                                                        <img src="{{url('images/')}}/call.svg" alt="">
                                                        <div class="alert alert-danger mt-1 mb-1 phoneNumberError" style="display: none;">Please enter phone number</div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 offset-lg-2">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">Email id</label>
                                                        <input type="email" readonly class="form-control" name="email" required="required" placeholder="Enter email id"
                                                        value="{{Auth::user()->email}}"
                                                        >
                                                        <img src="{{url('images/')}}//mail.svg" alt="">
                                                        <div class="alert alert-danger mt-1 mb-1 emailError" style="display: none;">Please enter email</div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">Password</label>
                                                        <input type="password" class="form-control" name="password" required="required" placeholder="Enter password" minlength="8" minlength="25" autocomplete="off">
                                                        <div class="alert alert-danger mt-1 mb-1 passwordError" style="display: none;">Please enter password</div>
                                                        <div class="alert alert-danger mt-1 mb-1 mpasswordError" style="display: none;">Password does not match with confirm password</div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 offset-lg-2">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                                                        <input type="password" class="form-control" name="password_confirmation" required="required" placeholder="Confirm Password" minlength="8" minlength="25" autocomplete="off">
                                                        <div class="alert alert-danger mt-1 mb-1 cpasswordError" style="display: none;">Please enter confirm password</div>
                                                        <div class="alert alert-danger mt-1 mb-1 mpasswordError" style="display: none;">Confirm Password does not match withpassword</div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="signup-field">
                                                        <label for="exampleInputEmail1" class="form-label">City</label>
                                                        <input type="text" class="form-control f-img" name="city" placeholder="City" value={{Auth::user()->city}}>
                                                        <img src="{{url('images/')}}/location_on.svg" alt="">
                                                        <div class="alert alert-danger mt-1 mb-1 cityError" style="display: none;">Please enter city</div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                            <div class="col-md-2">
                                            <button class="btn btn-custom saveDetailsBtn"> Save Details</button>
                                            </div>
                                            </div>
                                </form>
                                            
                                </div>
                                <div class="tab-pane fade {{($aboutUs ? 'show active':'')}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form action="{{url('editprofile')}}" method="post">
                                    @csrf
                                <input type="hidden" name="id"  value=" {{Auth::user()->id}}">
                                <input type="hidden" name="about_section"  value="about section">
                                <div class="row mt-5">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">About</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="about" rows="3" maxlength="255">{{Auth::user()->about}}</textarea>
                                        <input type="hidden" name="about_hidden" value="1">
                                    </div>
                                                
                                            </div>
                                            <div class="row mt-3">
                                            <div class="col-md-2">
                                            <button class="btn btn-custom">Save Details</button>
                                            </div>
                                            </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                    </div> -->
                </div>
            <!-- </form>  -->
            <div style="height: 200px;" ></div>         
        </div>

        <script>
            $(document).on("change", ".inputfile", function() {
                ! function(e) {
                    if (e.files && e.files[0]) {
                        var t = new FileReader;
                        t.onload = function(e) {
                            $(".profile-pic").attr("src", e.target.result)
                        }, t.readAsDataURL(e.files[0])
                    }
                }(this)
            });
        </script>
@endsection('content')

