<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
  @include('includes.web.head')
</head>

<body class="">
	<div class="loaderImage"></div>
  @include('includes.web.header')
  @yield('content')   
  @include('includes.landing.footer')
  @include('includes.web.script')
 
  
</body>


</html>