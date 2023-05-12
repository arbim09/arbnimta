{{-- 
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-4/css/bootstrap.min.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/">CHIKADMIN</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
      	@auth
      		<a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
        </form>
      	@else
      		<a class="nav-link" href="{{ route('login') }}">Login</a>
          
      	@endauth
      </li>
    </ul>
    <span class="navbar-text">

    </span>
  </div>
</nav>

<div class="container-fluid mt-5">
	
	<div class="jumbotron">
    @guest
    <h1 class="display-4">Selamat Datang di CHIKADMIN</h1>
    @endguest

    @auth
    <h1 class="display-4">Hello , {{ Auth::user()->name }}</h1>
    @endauth
    
    <p class="lead">Chikadmin adalah simpel starter sb-admin-2 untuk laravel, keuntungannya adalah kita tidak harus mengintegrasikan sb-admin-2 dari awal.</p>
	  <hr class="my-4">

    <div class="row">
      
      <div class="col-lg-6 mb-3">
        <div class="card">
          <div class="card-header">
            Email & Password Login
          </div>

          <div class="card-body">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Email</th>
                  <th scope="col">Password</th>
                  <th scope="col">Level</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>admin@gmail.com</td>
                  <td>password</td>
                  <td>admin</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>ayane@gmail.com</td>
                  <td>password</td>
                  <td>admin</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>kotone@gmail.com</td>
                  <td>password</td>
                  <td>user</td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>mapple@gmail.com</td>
                  <td>password</td>
                  <td>user</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">Beberapa Fitur Simpel</div>
          <div class="card-body">
            <ul>

              <li>Autentikasi dengan Laravel Auth</li>
              <li>Autorisasi dengan Laravel Gate</li>
              <li>Yajra DataTable Serverside</li>
              <li>Ajax crud dengan datatable serverside</li>
            </ul>

          </div>
        </div>
      </div>

    </div>
  </div>

</div>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-4/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-4/js/bootstrap.min.js') }}"></script>
</body>
</html> --}}

@extends('layout.anggotaLayouts.main')

@push('css')
  
@endpush
@section('content')
{{-- masih belum jadi --}}
{{-- <div>
  <div class="splide single-slider slider-dots-under slider-boxed">
    <div class="splide__track">
      <div class="splide__list">
        @foreach($banners as $banner)
          <div class="splide__slide">
            <div data-card-height="200" class="card bg-11 rounded-m shadow-l" >
              <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="{{ $banner->name }}" style="width: 100px; height: 100px;">
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div> --}}
@foreach($banners as $banner)
  <div class="splide__slide">
    <div data-card-height="200" class="card bg-11 rounded-m shadow-l">
      <img src="{{ asset('/images/banners/'.$banner->image) }}" alt="{{ $banner->name }}" style="width: 700px; height: 100px;">
      <div class="card-overlay rounded-m bg-gradient-fade opacity-90"></div>
    </div>
  </div>
@endforeach


<div class="divider mx-3 mt-5 mb-4"></div>

<div class="card card-style">
  <div class="content px-2 text-center">
      <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase">Berita</h5>
      <h2>Berita Terkini</h2>
      <div class="row text-center row-cols-3 mb-n1">
          @foreach($berita as $brt)
              <a class="col p-1" data-gallery="gallery-1" href="{{ route('berita.show', $brt->id) }}" title="{{ $brt->title }}">
                  <p>{{ substr($brt->title, 0, 30) }}...</p>
                  <img src="{{ asset('/images/posts/'.$brt->image) }}" class="preload-img img-fluid rounded-m" alt="img">
              </a>
          @endforeach
      </div>
      <br>
      <a href="#" class="btn-full btn gradient-blue">Lihat Lainya</a>
  </div>
</div>
    
@endsection