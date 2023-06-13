@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Verifikasi</title>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        <div class="page-content header-clear-medium">
            <div class="card card-style">
                <div class="content">
                    <h1 class="text-center font-800 font-22 mb-2">Account Verification</h1>
                    <p class="text-center font-13 mt-n2 mb-2">Enter your One Time Passcode below</p>
                    <div class="text-center mb-3 pt-3 pb-2">
                        <form
                            action="{{ route('verification.verify', ['id' => Auth::id(), 'hash' => sha1(Auth::user()->email)]) }}"
                            method="POST">
                            @csrf
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <input class="otp mx-1 text-center font-24 font-900" type="text" name="code[]"
                                maxlength="1" autocomplete="off" required>
                            <button type="submit"
                                class="btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 btn-full shadow-bg shadow-bg-s">Verify</button>
                        </form>
                    </div>

                    <p class="pt-2 font-11 text-center pt-4">Didn't receive your code? <a
                            href="{{ route('verification.resend') }}">Resend OTP</a>
                    </p>
                </div>
            </div>

            <!-- Verified -->
            <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached bg-theme" id="menu-verified">
                <div class="content mt-3">
                    <div class="d-flex pb-2">
                        <div class="align-self-center">
                            <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase pt-1">Thank you</h5>
                            <h1 class="font-700 font-20">Identity Confirmed</h1>
                        </div>
                        <div class="align-self-center ms-auto">
                            <a href="#" data-bs-dismiss="offcanvas" class="icon icon-m"><i
                                    class="bi bi-x-circle-fill color-red-dark font-18 me-n4"></i></a>
                        </div>
                    </div>
                    <p>
                        Thank you for confirming your identity! You can create this box as a warning as well.
                    </p>
                    <a href="#" data-bs-dismiss="offcanvas"
                        class='btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 btn-full shadow-bg shadow-bg-s'>Awesome</a>
                </div>
            </div>
        </div>
    </div>
@endsection
