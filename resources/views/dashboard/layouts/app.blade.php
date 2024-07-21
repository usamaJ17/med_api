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

<body class="hold-transition dark-skin sidebar-mini theme-success fixed">
	
<div class="wrapper">
	<div id="loader"></div>

    @include('dashboard.layouts.header')
  
  @include('dashboard.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Main content -->
		<section class="content">
			@yield('content')
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
  @include('dashboard.layouts.footer')
  
  
</div>
<!-- ./wrapper -->		
	@include('dashboard.layouts.chat')
	
	<!-- Page Content overlay -->
	
	
	<!-- Vendor JS -->
	<script src="{{ asset('dashboard/js/vendors.min.js') }}"></script>
	<script src="{{ asset('dashboard/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('dashboard/assets/icons/feather-icons/feather.min.js') }}"></script>
	
	<script src="{{ asset('dashboard/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js')}}"></script>
	<script src="{{ asset('dashboard/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js')}}"></script>
	
	
	<!-- Rhythm Admin App -->
	<script src="{{ asset('dashboard/js/template.js')}}"></script>
	<script src="{{ asset('dashboard/js/pages/dashboard2.js')}}"></script>
    @yield('script')
	
</body>
</html>
