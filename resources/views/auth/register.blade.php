<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/anggotatemplate/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/anggotatemplate/fonts/bootstrap-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/anggotatemplate/styles/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="manifest" href="{{ asset('/anggotatemplate/_manifest.json') }}">
    <meta id="theme-check" name="theme-color" content="#FFFFFF">
    <link rel="shortcut icon" href="{{ asset('images/backend/logo-rtik.ico') }}" />
</head>

<body class="theme-light">


    <!-- Your Page Content Goes Here-->
    <div id="page">
        <div class="page-content">
            <br>
            @if (session('success'))
                <div class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0"
                    role="alert">
                    <i class="bi bi-check-circle-fill pe-2"></i>
                    <strong>Selamat</strong> - Anda telah terdaftar
                    <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('email_exists'))
                <div class="alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show" role="alert">
                    <i class="bi bi-exclamation-triangle pe-2"></i>
                    <strong>Warning</strong> - Alamat Email Sudah Digunakan!
                    <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('password_tidaksama'))
                <div class="alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show" role="alert">
                    <i class="bi bi-exclamation-triangle pe-2"></i>
                    <strong>Warning</strong> - Password Tidak sama!
                    <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            <br>
            <div class="card card-style">
                <div class="content">
                    <h1 class="text-center font-800 font-30 mb-2">Daftar Akun</h1>
                    <p class="text-center font-13 mt-n2 mb-3">Buat Akun Anda</p>
                    <form action="{{ route('anggota.register') }}" method="POST" enctype="multipart/form-data"
                        id="anggota">
                        @csrf
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person-circle font-14"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" name="name"
                                placeholder="Nama" required />
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50 @error('name') is-invalid @enderror">Nama
                                Lengkap{!! printRequired() !!}</label>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-phone font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1a" name="no_hp"
                                placeholder="No Hp" required />
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">No
                                Hp</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-at font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1a" name="email"
                                placeholder="Email" value="{{ old('email') }}" required />
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Email</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person font-16"></i>
                            <select class="form-control rounded-xs" name="jenis_kelamin" id="gender" required>
                                <option value="">- Pilih Gender -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <label for="gender"
                                class="color-theme form-label-always-active font-10 opacity-50">Jenis
                                Kelamin</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-geo-alt font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1"
                                placeholder="Tempat Lahir" name="tempat_lahir" required />
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Tempat
                                Lahir</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-calendar2-event font-16"></i>
                            <input type="date" class="form-control rounded-xs" id="input-tanggal_lahir"
                                placeholder="Tanggal Lahir" name="tanggal_lahir" required min="1900-01-01" />
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Tanggal Lahir</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-calendar2-event font-16"></i>

                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Umur</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-star font-16"></i>
                            <select class="form-select rounded-xs" id="c1" name="agama" required>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katholik">Katholik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Khonghucu">Khonghucu</option>
                                <option value="Lainya">Lainya</option>
                            </select>
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Agama</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-book font-16"></i>
                            <select class="form-select rounded-xs" id="c2" name="pendidikan" required>
                                <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                <option value="Belum Tamat SD/Sederajat">Belum Tamat SD/Sederajat</option>
                                <option value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                                <option value="SLTP/Sederajat">SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                <option value="Diploma I/II">Diploma I/II</option>
                                <option value="Akademi/Diploma III/S. muda">Akademi/Diploma III/S. muda</option>
                                <option value="Diploma IV/Strata I">Diploma IV/Strata I</option>
                                <option value="Strata II">Strata II</option>
                                <option value="Strata III">Strata III</option>
                            </select>
                            <label for="c2"
                                class="color-theme form-label-always-active font-10 opacity-50">Pendidikan</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person-fill font-16"></i>
                            <select class="form-select select2" name="pekerjaan_id" required>
                                @foreach ($kerja as $krj)
                                    <option value="{{ $krj->id }}">{{ $krj->nama }}</option>
                                @endforeach
                            </select>
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Pekerjaan</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-alt font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1"
                                placeholder="Alamat" name="alamat" required />
                            <label for="c1"
                                class="color-theme form-label-always-active font-10 opacity-50">Address</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-asterisk font-12"></i>
                            <input type="password" class="form-control rounded-xs" name="password" id="password"
                                placeholder="Password" required />
                            <label for="password" class="color-theme">Password</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-asterisk font-12"></i>
                            <input type="password" class="form-control rounded-xs" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password" />
                            <label for="password_confirmation" class="color-theme">Konfirmasi Password</label>
                        </div>
                        <button type="submit"
                            class='btn rounded-sm btn-m gradient-blue text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s'>Daftar</button>
                    </form>
                    <div class="d-flex">
                        <div>
                            <a href="{{ route('login') }}" class="color-theme  font-12">Sudah Punya Akun? Login
                                Sekarang!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="{{ asset('/anggotatemplate/scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/anggotatemplate/scripts/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#anggota').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this); // Buat objek FormData untuk menyimpan data form

                $.ajax({
                    url: '{{ route('anggota.register') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    processData: false, // Jangan memproses data secara otomatis
                    contentType: false, // Jangan mengatur tipe konten secara otomatis
                    success: function(response) {
                        swal({
                            title: 'Selamat Bergabung!',
                            text: response.message,
                            icon: 'success',
                            button: 'Ok'
                        }).then(function() {
                            location.href = "{{ route('login') }}";
                        });
                    },
                    error: function(response) {
                        swal({
                            title: 'Gagal!',
                            text: response.responseJSON.message,
                            icon: 'error',
                            button: 'Ok'
                        });
                    }
                });
            });

            $('#input-tanggal_lahir').on('input', function() {
                var dob = new Date($(this).val());
                var today = new Date();
                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                $('#input-umur').val(age);
            });
        });
    </script>
    <script>
        // Inisialisasi Select2 pada elemen dengan class "select2"
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        // Fungsi untuk menghilangkan notifikasi setelah 10 detik
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    </script>
</body>
