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
            <form method="get" action="{{url('editprofile')}}">
            <div class="row mt-5 mh-100">
                    <div class="col-md-2">
                       <div class="image_container" style="width: 150px;height: 150px;margin: auto; position: relative;">
                            <img class="profile-pic" src="{{ isset($profilePic) ? asset('profile_images/'.$profilePic) : asset('images/no_avatar.png') }}" alt="profile-pic" style="width: 100% !important; height: 100% !important; border-radius: 100%; object-fit: cover; object-position: top;">
                            {{-- <div class="image_inner" style="background-color: #ffffff; width: 30px; height: 30px;border-radius: 100%; position: absolute; bottom: 0; right:19px;border:1px solid">
                                <input class="inputfile" type="file" name="pic" accept="image/*">
                                <label><i class="fa fa-pencil"></i></label>
                            </div> --}}
                       </div>
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
                                    <a class="nav-link active contactTab" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Contact Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link aboutTab" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">About</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content profile-tab" id="myTabContent">
                                <div class="tab-pane fade show active contactTabPane" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row mt-5">
                                        <div class="col-md-4">
                                            <h6 class="cfh">Name</h6>
                                            <p class="cf"> {{Auth::user()->first_name}}  {{Auth::user()->last_name}} </p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="cfh">Phone Number</h6>
                                            <p class="cf">{{Auth::user()->phone_number}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="cfh">City</h6>
                                            <p class="cf">{{Auth::user()->city}}</p>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6 class="cfh">Email</h6>
                                                <p class="cf">{{Auth::user()->email}}</p>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <a href=""><button class="btn btn-custom"><i class="fa fa-pencil"></i>&nbsp; Edit Contact Info</button></a>
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                                <div class="tab-pane fade aboutTabPane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row mt-5">
                                                    <div class="col-md-10">
                                                        <h6 class="cfh">About</h6>
                                                        <p class="cf">{{Auth::user()->about}}</p>
                                                    </div>
                                                    
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <button type="button" id="change-url-btn" class="btn btn-custom"><i class="fa fa-pencil"></i>&nbsp; Edit About Info</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                    </div> -->
                </div>
            </form> 
            <div style="height: 200px;" ></div>         
        </div>
        <script>
            $(document).ready(function() {  
                $('#change-url-btn').on('click', function() {
                    // Change the URL with JavaScript's window.location
                    window.location.href = '/editaboutus';
                });
            });
        </script>
@endsection('content')


