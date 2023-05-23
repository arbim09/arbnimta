<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
@yield('title')
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
</div>
<!--End of Page ID-->

<script src="{{asset('/anggotatemplate/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('/anggotatemplate/scripts/custom.js')}}"></script>
@stack('js')
</body>