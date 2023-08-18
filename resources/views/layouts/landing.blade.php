<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
  @include('includes.landing.head')
</head>

<body class="">
	<div class="loaderImage"></div>
  @include('includes.landing.header')
  <div style="min-height: 100vh;">
    @yield('content')
  </div>
 
  @include('includes.landing.footer')
  @include('includes.landing.script')
  @yield('scripts')
</body>

</html>