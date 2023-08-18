<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href='https://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- css link  -->
        <link rel="stylesheet" href="{{url('css/landing.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="{{asset('/css/course.css')}}">
        <link rel="stylesheet" href="{{asset('/css/membership2.css')}}">
        <link rel="stylesheet" href="{{asset('/css/webinar.css')}}">
        <link rel="stylesheet" href="{{url('css/home.css')}}">
        <link rel="stylesheet" href="{{url('css/signup.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <style type="text/css">
                .loaderImage {
                       display: none;
                       position: fixed;
                       top: 0px;
                       right: 0px;
                       width: 100%;
                       height: 100%;
                       background-color: #000;
                       background-image: url({{ asset('images/loading.gif') }});
                       background-repeat: no-repeat;
                       background-position: center;
                       z-index: 10000000;
                       opacity: 0.4;
                       filter: alpha(opacity=40); /* For IE8 and earlier */
                   }
                   li.nav-item {
                    margin-left: 20px;
                    }
        </style>

    </head>
    <script>
siteUrl = '<?php echo URL::to('/'); ?>/';
    </script>
    <body>
        <div class="loaderImage"></div>
        <?php 
        use App\Models\UserSubscribedPlan;
        $subs = UserSubscribedPlan::join('subscriptions','subscriptions.id','user_subscribed_plans.subscription_id')
                ->where('user_id',Auth::user()->id)->where('is_active',1)
                ->select('subscriptions.plan_name','user_subscribed_plans.*')->first(); 
        ?>
        <header>
            <div class="container">
                <div class="main-header mt-4 mb-4">
                    <div class="pull-right" style="margin-top: 1.3rem;">
                    <div class="dropdown">
                            <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation="">
                                <div class="avatar avatar-sm avatar-circle mt-1">
                                    <img class="avatar-img" src="{{ isset(Auth::user()->profile_pic) ? asset('profile_images/'.Auth::user()->profile_pic) : asset('images/no_avatar.png') }}" alt="User Avatar" width="42" height="42" style="border-radius: 100%; object-fit: cover; object-position: top;">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 18rem;" data-bs-popper="static">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Profile </a>
                                <div class="dropdown-divider"></div> 
                                <?php if($subs != null){ ?>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                        <!-- <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm avatar-dark avatar-circle">
                                            <span class="avatar-initials">HS</span>
                                            </div>
                                        </div> -->
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Subscription Plan &nbsp;: <span class="badge bg-primary rounded-pill text-uppercase ms-1">{{ isset($subs->plan_name) ? strtoupper($subs->plan_name) : 'N/A' }}</span></h6>
                                            <span class="card-text">Expires on: {{$subs->subscription_end_date}}</span>
                                        </div>
                                        </div>
                                    </a> 
                                <?php } elseif (Auth::user()->is_sign_up_free == 1 && $subs != null){ ?>
                                    <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Subscription Plan &nbsp;: <span class="badge bg-primary rounded-pill text-uppercase ms-1">{{ isset($subs->plan_name) ? strtoupper($subs->plan_name) : 'N/A' }}</span></h6>
                                        </div>
                                        </div>
                                        </a>
                                    <?php } else{ ?>
                                        <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Subscription Plan &nbsp;: <span class="badge bg-primary rounded-pill text-uppercase ms-1">N/A</span></h6>
                                        </div>
                                        </div>
                                        </a> 
                                        
                                    <?php }   ?>
                                <div class="dropdown-divider"></div> 

                        
                                {{-- <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Sign out</a> --}}
                                <a class="dropdown-item" href="{{ route('logout') }}">Sign out</a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="logo">
                            <a href="{{ \Auth::user() ? url('/home') : url('/') }}"><img src="{{url('logo/header-logo.svg')}}"  style="height: 80px;"  class="img-responsive res-logo" alt="alt text"></a>
                         </div>
                        
                        <!-- <a class="navbar-brand" href="#">Speak2Impact Academy</a> -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(1) === 'home' ? 'active' : null }}" aria-current="page" href="{{url('home')}}">Home</a>
                                </li>
                                <li class="nav-item">
                                     @if (Auth::check() && (isset(Auth::user()->email_verified_at)) && Auth::user()->getUserSubscription(Auth::user()->id) == null)
                                     <?php ?>
                                    <a class="nav-link {{ Request::segment(1) === 'courses' ? 'active' : null }}" href="{{url('courses')}}"><i class="fa fa-lock" aria-hidden="true" color="black"></i> Courses</a>
                                    
                                    @else
                                    <a class="nav-link {{ Request::segment(1) === 'courses' ? 'active' : null }}" href="{{ url('courses') }}">Courses</a>
                                    @endif
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(1) === 'meeting' ? 'active' : null }}" href="{{url('meeting')}}">Schedule meeting with Coach</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::segment(1) === 'practice' ? 'active' : null }}"  href="{{url('practice')}}">Practice</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  {{ Request::segment(1) === 'webinars' ? 'active' : null }}" href="{{url('webinars')}}">Webinars</a>
                                </li>
                            </ul>
                        </div>

                        
                        <!-- dropdown -->






                    </nav>
                </div>
            </div>
           @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Success! </strong>
        {{ Session::get('success') }}
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error!</strong> {{ Session::get('error') }}

    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif

        </header>
        <!-- END HEAD -->
      