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
    <div class="page-content pb-0 mb-0">

        <div class="card card-style m-0 bg-transparent shadow-0 bg-10 rounded-0" data-card-height="cover">
            <div class="card-center">
                <div class="card card-style">
                    <div class="content">
                        <h1 class="text-center font-800 font-30 mb-2">Daftar Akun</h1>
                        <p class="text-center font-13 mt-n2 mb-3">Buat Akun Anda</p>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person-circle font-14"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" placeholder="John Doe"/>
                            <label for="c1" class="color-theme">Your Name</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-at font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1a" placeholder="Email Address"/>
                            <label for="c1a" class="color-theme">Email Address</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-asterisk font-12"></i>
                            <input type="text" class="form-control rounded-xs" id="c2" placeholder="Password"/>
                            <label for="c2" class="color-theme">Pasword</label>
                        </div>
                        <a href="#" class='btn rounded-sm btn-m gradient-blue text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s'>Create Account</a>
                        <div class="d-flex">
                            <div>
                                <a href="{{route('login')}}" class="color-theme opacity-30 font-12">Login Account</a>
                            </div>
                            <div class="ms-auto">
                                <a href="page-register-2.html" class="color-theme opacity-30 font-12">Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

</div>



<script src="{{asset('/anggotatemplate/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('/anggotatemplate/scripts/custom.js')}}"></script>
</body>