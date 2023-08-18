<div class="container" style=" max-width: 1440px;">
          <nav class="navbar" style="padding-left: 50px;
    padding-right: 50px;">
            <div class="logo">
            <img src="{{url('logo/header-logo.svg')}}"   style="height: 80px;" class="css-class" alt="alt text">
            </div>
            <div class="login-action">
            @if (Auth::check())
            <a href="{{ route('logout') }}"><button class="login login-action-gap" >Logout</button></a>
            <a href="{{route('membershipPlans')}}"><button class="start-learning">Start Learning</button></a>
            @else
            <a href="{{url('login')}}"><button class="login login-action-gap">Login</button></a>
            <a href="{{route('register')}}"><button class="start-learning">Sign up</button></a>
            @endif
             
            </div>
            </nav>
            @if (Session::has('error'))
            <div class="alert alert-error text-center">
                <p>{{ Session::get('error') }}</p>
            </div>

            @endif
        </header>
    </div>