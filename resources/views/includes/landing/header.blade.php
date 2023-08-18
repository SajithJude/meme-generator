<style>
  nav.navbar{
    padding-left: 50px;padding-right: 50px;
  }
  @media only screen and (max-width:576px){
nav.navbar{
  padding-left: 0 !important;
  padding-right: 0 !important;
}
.login-action-gap{
  margin-right: 1rem !important;
}
.hero-heading h1{
  font-size: 2.5rem !important;
    line-height: 1.5 !important;
}
.hero-heading span{
  font-size: 1.25rem !important;
}
.fun-facts h2{
  font-size: 2.5rem !important;
}
.facts{
  flex-direction: column;
}
  }
</style>

<div class="container" style="margin-top: 1.5rem!important; max-width: 1440px;">
    <header>
      <nav class="navbar">
        <div class="logo">
          <a href="{{ Auth::check() ? '/home' : '/' }}"><img src="{{url('logo/header-logo.svg')}}"  style="height: 80px;" class="css-class cursor-pointer" alt="alt text"></a>
        </div>
        <div class="login-action">
            @if (Auth::check())
              <a href="{{ route('logout') }}"><button class="login login-action-gap" >Logout</button></a>
              @if(request()->is('membership-plans')) <a href="{{url('/home')}}"><button class="start-learning">Back</button></a> @endif
            @else
              @if (Auth::check() && Auth::user()->email_verified_at)
                <a href="{{ route('logout') }}"><button class="login login-action-gap" >Logout</button></a>
                <a href="{{route('membershipPlans')}}"><button class="start-learning">Start Learning</button></a>
              @else
                <a href="{{url('login')}}"><button class="login login-action-gap">Login</button></a>
                @if(Request::segment(1) != "verify-email" )
                  <a href="{{route('register')}}"><button class="start-learning" style="max-width: inherit; padding: 18px 19px;">Get started now</button></a>
                @endif
              @endif
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