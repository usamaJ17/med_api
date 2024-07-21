<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('dashboard/images/favicon.ico') }}">

    <title> @yield('title') </title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('dashboard/css/vendors_css.css')}}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('dashboard/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('dashboard/css/skin_color.css')}}">
    @yield('css')
</head>
	
<body class="hold-transition theme-primary bg-img" style="background-image: url({{ asset('dashboard/images/auth-bg/bg-'.rand(8, 12).'.jpg') }})">

    @yield('content')

	<!-- Vendor JS -->
	<script src="{{ asset('dashboard/js/vendors.min.js') }}"></script>
	<script src="{{ asset('dashboard/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('dashboard/assets/icons/feather-icons/feather.min.js') }}"></script>
    @yield('script')

</body>
</html>
