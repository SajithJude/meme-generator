<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
  @include('includes.main.headhome')
</head>

<body class="" style="background-color: rgb(255, 255, 249);">
	<div class="loaderImage"></div>
  @include('includes.main.header')
  @yield('content')   
  @include('includes.main.footer')
  @include('includes.main.script')
  
</body>

</html>