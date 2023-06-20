@extends('layout.anggotaLayouts.main')

@section('title')
    <title>Verifikasi</title>
@endsection

@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        <div class="page-content header-clear-medium">
            <div class="card card-style">
                <div class="content">
                    <h1 class="text-center font-800 font-22 mb-2">Account Verification</h1>

                    @if ($user->email_verified_at)
                        <p class="text-center font-13 mt-n2 mb-2">Selamat Bergabung</p>
                    @else
                        <p class="text-center font-13 mt-n2 mb-2">Silakan cek email Anda</p>
                    @endif

                    @if ($user->email_verified_at)
                        <div class="text-center mb-3 pt-3 pb-2">
                            <p>Email Sudah Terverifikasi</p>
                        </div>
                    @else
                        <div class="text-center mb-3 pt-3 pb-2">
                            <p>Kode Verifikasi Telah Dikirim</p>
                        </div>
                    @endif

                    @if ($user->email_verified_at)
                        <!-- Menambahkan kondisi jika email sudah terverifikasi -->
                        <p class="pt-2 font-11 text-center pt-4">Email telah terverifikasi</p>
                    @else
                        <p class="pt-2 font-11 text-center pt-4">Belum menerima kode? <a
                                href="{{ route('verification.resend') }}">Kirim Ulang OTP</a>
                        </p>
                    @endif

                </div>
            </div>


        </div>
    </div>
@endsection
