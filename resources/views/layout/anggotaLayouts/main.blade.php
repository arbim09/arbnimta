<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Duo Mobile PWA Kit</title>
<link rel="stylesheet" type="text/css" href="{{asset('/anggotatemplate/styles/bootstrap.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/anggotatemplate/fonts/bootstrap-icons.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/anggotatemplate/styles/style.css')}}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="manifest" href="{{asset('/anggotatemplate/_manifest.json')}}">
<meta id="theme-check" name="theme-color" content="#FFFFFF">
<link rel="shortcut icon" href="{{asset('images/backend/logo-rtik.ico')}}"/>
@stack('css')

<body class="theme-light">




<div id="page">
	{{-- Header --}}
	@include('layout.anggotaLayouts.header')

	@include('layout.anggotaLayouts.footer')

	@include('layout.anggotaLayouts.sidebar')

	<!-- Main Sidebar-->
	<div id="menu-main" data-menu-active="nav-homes" data-menu-load="menu-main.html"
		style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">
	</div>

	<!-- Menu Highlights-->
	<div id="menu-color" data-menu-load="menu-highlights.html"
		style="height:340px" class="offcanvas offcanvas-bottom offcanvas-detached rounded-m">
	</div>


    <!-- Your Page Content Goes Here-->
    <div class="page-content header-clear-medium">
		@yield('content')
    </div>
	<!-- End of Page Content-->

	<div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-ios">
	   <div class="content">
			 <img src="app/icons/icon-128x128.png" alt="img" width="80" class="rounded-l mx-auto my-4">
		  <h1 class="text-center font-800 font-20">Add Duo to Home Screen</h1>
		  <p class="boxed-text-xl">
			  Install Duo on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".
		  </p>
		   <a href="#" class="pwa-dismiss close-menu gradient-blue shadow-bg shadow-bg-s btn btn-s btn-full text-uppercase font-700  mt-n2" data-bs-dismiss="offcanvas">Maybe Later</a>
	   </div>
   </div>

   <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-android">
	   <div class="content">
		   <img src="app/icons/icon-128x128.png" alt="img" width="80" class="rounded-m mx-auto my-4">
		   <h1 class="text-center font-700 font-20">Install Duo</h1>
		   <p class="boxed-text-l">
			   Install Duo to your Home Screen to enjoy a unique and native experience.
		   </p>
		   <a href="#" class="pwa-install btn btn-m rounded-s text-uppercase font-900 gradient-highlight shadow-bg shadow-bg-s btn-full">Add to Home Screen</a><br>
		   <a href="#" data-bs-dismiss="offcanvas" class="pwa-dismiss close-menu color-theme text-uppercase font-900 opacity-50 font-11 text-center d-block mt-n1">Maybe later</a>
	   </div>
   </div>

   <!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Yakin Logout ?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="btn btn-primary">Logout</button>
				</form>
			</div>
		</div>
	</div>
</div>

</div>
<!--End of Page ID-->

<script src="{{asset('/anggotatemplate/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('/anggotatemplate/scripts/custom.js')}}"></script>
@stack('js')
</body>