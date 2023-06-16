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
                    <p class="text-center font-13 mt-n2 mb-2">Silakan cek email Anda</p>
                    <div class="text-center mb-3 pt-3 pb-2">
                        <!-- Email verification form -->
                    </div>
                    <p class="pt-2 font-11 text-center pt-4">Belum menerima kode? <a
                            href="{{ route('verification.resend') }}">Kirim Ulang OTP</a>
                    </p>
                </div>
            </div>

            <!-- Verified -->
            <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached bg-theme" id="menu-verified">
                <div class="content mt-3">
                    <div class="d-flex pb-2">
                        <div class="align-self-center">
                            <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase pt-1">Terima Kasih</h5>
                            <h1 class="font-700 font-20">Identitas Terkonfirmasi</h1>
                        </div>
                        <div class="align-self-center ms-auto">
                            <a href="#" data-bs-dismiss="offcanvas" class="icon icon-m"><i
                                    class="bi bi-x-circle-fill color-red-dark font-18 me-n4"></i></a>
                        </div>
                    </div>
                    <p>
                        Terima kasih telah mengonfirmasi identitas Anda! Anda dapat menggunakan kotak ini sebagai peringatan
                        juga.
                    </p>
                    <a href="#" data-bs-dismiss="offcanvas"
                        class='btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 btn-full shadow-bg shadow-bg-s'>Terkemuka</a>
                </div>
            </div>
        </div>
    </div>
@endsection
