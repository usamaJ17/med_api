  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">	
		<!-- Logo -->
		<a href="index.html" class="logo">
		  <!-- logo-->
		  <div class="logo-mini w-50">
			  <span class="light-logo"><img src="{{ asset('dashboard/images/logo-letter.png')}}" alt="logo"></span>
			  <span class="dark-logo"><img src="{{ asset('dashboard/images/logo-letter.png')}}" alt="logo"></span>
		  </div>
		  <div class="logo-lg">
			  <span class="light-logo"><img src="{{ asset('dashboard/images/logo-dark-text.png')}}" alt="logo"></span>
			  <span class="dark-logo"><img src="{{ asset('dashboard/images/logo-dark-text.png')}}" alt="logo"></span>
		  </div>
		</a>	
	</div>  
    <!-- Header Navbar -->
	@include('dashboard.layouts.nav')
  </header>