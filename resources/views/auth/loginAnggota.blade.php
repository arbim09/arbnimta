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


<!-- Your Page Content Goes Here-->
<div id="page">
    <!-- Your Page Content Goes Here-->
    <div class="page-content header-clear-medium">

      <div class="card card-style">
              <div class="content">
                <h1 class="text-center font-800 font-30 mb-2">Login</h1>
                <p class="text-center font-13 mt-n2 mb-3">Enter your Credentials</p>
                <form method="POST" action="{{ route('login.post') }}">
                  @csrf
                  <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-person-circle font-14"></i>
                    <input type="text" class="form-control rounded-xs" id="email" name="email" placeholder="Email" required/>
                    <label for="email" class="color-theme">Email</label>
                  </div>
                  <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-asterisk font-12"></i>
                    <input type="password" class="form-control rounded-xs" id="password" name="password" placeholder="Password" required/>
                    <label for="password" class="color-theme">Password</label>
                  </div>
                  <button type="submit" class="btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s">Sign In</button>
                </form>
                <div class="d-flex">
                  <div class="ms-auto">
                    <a href="{{ route('register') }}" class="color-theme opacity-30 font-12">Daftar Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
      </div>
    <!-- End of Page Content-->
</div>



<script src="{{asset('/anggotatemplate/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('/anggotatemplate/scripts/custom.js')}}"></script>
</body>