@extends('layout.auth.app', [
    'title' => 'Buat Password Baru',
])

@push('css')
@endpush

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Silahkan ganti password anda</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="password" aria-describedby="passwordHelp" placeholder="Password Baru">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation"
                                            class="form-control form-control-user" id="password_confirmation"
                                            aria-describedby="passwordHelp" placeholder="Konfirmasi Password Baru">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Buat Akun!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
