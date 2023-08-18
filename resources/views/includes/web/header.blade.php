<?php //dd(Request::segment(1)) ;?>
<div class="container" style=" max-width: 1440px;">
          <nav class="navbar" style="padding-left: 50px;
    padding-right: 50px;">
            <div class="logo">
                <a href="/"><img src="{{url('logo/header-logo.svg')}}"   style="height: 80px;" class="css-class" alt="alt text"></a>
            </div>
            <div class="login-action">
            @if (Auth::check() && Auth::user()->email_verified_at  != NULL)
	            <a href="{{ route('logout') }}"><button class="start-learning login login-action-gap" >Logout</button></a>
	            <a href="{{route('membershipPlans')}}"><button class="start-learning">Start Learning</button></a>
	            @else
	            @if (Request::segment(1) == 'register')
	            	<a href="{{url('login')}}"><button class="start-learning">Login</button></a>
	            @endif
	            @if (Request::segment(1) == 'login')
	            	<a href="{{route('register')}}"><button class="start-learning">Sign up</button></a>
	            @endif            
            
            @endif
             
            </div>
            </nav>
            @if (Session::has('error'))
            <div class="alert alert-error text-center">
                <p>{{ Session::get('error') }}</p>
            </div>

            @endif
        
    </div>