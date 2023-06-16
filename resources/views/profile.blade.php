@extends('layout.anggotaLayouts.main')

@push('css')
    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .img-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @if (session('success'))
        <div class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0" role="alert">
            <i class="bi bi-check-circle-fill pe-2"></i>
            <strong>Selamat</strong> - {{ session('success') }}
            <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <br>
    <!-- Your Page Content Goes Here-->
    <div class="card card-style">
        <div class="content mb-0">
            <h6 class="font-700 mb-n1 color-highlight">Pengaturan Akun</h6>
            <h1 class="pb-2">Profil</h1>
            <form action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                id="anggota">
                @method('PUT')
                @csrf
                <input type="hidden" name="_method" value="POST">
                <div class="file-data">
                    @php
                        $foto_profil = auth()->user()->foto_profil ? asset('images/profil/') . '/' . auth()->user()->foto_profil : asset('images/profil/user.png');
                    @endphp
                    <img id="image-data" class="img-fluid rounded-s img-center" src="{{ $foto_profil }}"
                        style="max-width: 200px; max-height: 200px; ">
                    <div>
                        <input type="file" class="upload-file" name="foto_profil" accept="image/*">
                        <p
                            class="btn btn-full btn-m text-uppercase font-700 font-11 rounded-s upload-file-text shadow-0 color-black">
                            Ubah foto profil</p>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-person-circle font-14"></i>
                    <input type="text" class="form-control rounded-xs" id="c1" name="name"
                        placeholder="Nama Lengkap" value="{{ Auth::user()->name }}" />
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Nama</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-at font-16"></i>
                    <input type="email" class="form-control rounded-xs" id="c1" name="email" placeholder="Email"
                        value="{{ Auth::user()->email }}" />
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Email</label>
                    <span>(required)</span>
                </div>

                @if (Auth::user()->hasVerifiedEmail())
                    <p class="text-success">Email has been verified.</p>
                @else
                    <p class="text-warning">Email is not verified. Please check your inbox for the verification email.</p>
                    <a href="{{ route('verification.code') }}">Verify Email</a>
                @endif
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-star font-16"></i>
                    <select class="form-select rounded-xs" id="c1" name="agama">
                        <option value="Islam" {{ Auth::user()->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ Auth::user()->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katholik" {{ Auth::user()->agama == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                        <option value="Hindu" {{ Auth::user()->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ Auth::user()->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                        <option value="Khonghucu" {{ Auth::user()->agama == 'Khonghucu' ? 'selected' : '' }}>Khonghucu
                        </option>
                        <option value="Lainya" {{ Auth::user()->agama == 'Lainya' ? 'selected' : '' }}>Lainya</option>
                    </select>
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Agama</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-person-fill font-16"></i>
                    <select class="form-select select2" name="pekerjaan_id">
                        @foreach ($kerja as $krj)
                            <option value="{{ $krj->id }}"
                                {{ Auth::user()->pekerjaan_id == $krj->id ? 'selected' : '' }}>{{ $krj->nama }}
                            </option>
                        @endforeach
                    </select>
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Pekerjaan</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-phone font-16"></i>
                    <input type="text" class="form-control rounded-xs" id="c1" placeholder="No Telephone"
                        name="no_hp" value="{{ Auth::user()->no_hp }}" />
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Phone</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-alt font-16"></i>
                    <input type="text" class="form-control rounded-xs" id="c1" placeholder="Alamat" name="alamat"
                        value="{{ Auth::user()->alamat }}" />
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Address</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-person font-16"></i>
                    <select class="form-control rounded-xs" name="jenis_kelamin" id="gender">
                        <option value="">- Pilih Gender -</option>
                        <option value="Laki-laki" {{ Auth::user()->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan" {{ Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                    <label for="gender" class="color-theme form-label-always-active font-10 opacity-50">Jenis
                        Kelamin</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-geo-alt font-16"></i>
                    <input type="text" class="form-control rounded-xs" id="c1" placeholder="Tempat Lahir"
                        name="tempat_lahir" value="{{ Auth::user()->tempat_lahir }}" />
                    <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Tempat
                        Lahir</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-calendar2-event font-16"></i>
                    <input type="date" class="form-control rounded-xs" id="input-tanggal_lahir"
                        placeholder="Tanggal Lahir" name="tanggal_lahir"
                        value="{{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('Y-m-d') }}" />
                    <label for="input-tanggal_lahir"
                        class="color-theme form-label-always-active font-10 opacity-50">Tanggal Lahir</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-calendar2-event font-16"></i>
                    <input type="input" class="form-control rounded-xs" id="input-umur" placeholder="Umur"
                        name="umur" value="{{ Auth::user()->umur }} Tahun" readonly />
                    <label for="input-umur" class="color-theme form-label-always-active font-10 opacity-50">Umur</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-book font-16"></i>
                    <select class="form-select rounded-xs" id="c2" name="pendidikan">
                        <option value="Tidak/Belum Sekolah"
                            {{ Auth::user()->pendidikan == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah
                        </option>
                        <option value="Belum Tamat SD/Sederajat"
                            {{ Auth::user()->pendidikan == 'Belum Tamat SD/Sederajat' ? 'selected' : '' }}>Belum Tamat
                            SD/Sederajat</option>
                        <option value="Tamat SD/Sederajat"
                            {{ Auth::user()->pendidikan == 'Tamat SD/Sederajat' ? 'selected' : '' }}>Tamat SD/Sederajat
                        </option>
                        <option value="SLTP/Sederajat"
                            {{ Auth::user()->pendidikan == 'SLTP/Sederajat' ? 'selected' : '' }}>SLTP/Sederajat</option>
                        <option value="SLTA/Sederajat"
                            {{ Auth::user()->pendidikan == 'SLTA/Sederajat' ? 'selected' : '' }}>SLTA/Sederajat</option>
                        <option value="Diploma I/II" {{ Auth::user()->pendidikan == 'Diploma I/II' ? 'selected' : '' }}>
                            Diploma I/II</option>
                        <option value="Akademi/Diploma III/S. muda"
                            {{ Auth::user()->pendidikan == 'Akademi/Diploma III/S. muda' ? 'selected' : '' }}>
                            Akademi/Diploma III/S. muda</option>
                        <option value="Diploma IV/Strata I"
                            {{ Auth::user()->pendidikan == 'Diploma IV/Strata I' ? 'selected' : '' }}>Diploma IV/Strata I
                        </option>
                        <option value="Strata II" {{ Auth::user()->pendidikan == 'Strata II' ? 'selected' : '' }}>Strata
                            II</option>
                        <option value="Strata III" {{ Auth::user()->pendidikan == 'Strata III' ? 'selected' : '' }}>Strata
                            III</option>
                    </select>
                    <label for="c2"
                        class="color-theme form-label-always-active font-10 opacity-50">Pendidikan</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-at font-16"></i>
                    <input type="password" name="password"
                        class="form-control rounded-xs @error('password') is-invalid @enderror" id="input-password"
                        placeholder="********" maxlength="8" size="8">
                    <label for="input-password"
                        class="color-theme form-label-always-active font-10 opacity-50">Password</label>
                </div>

                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-at font-16"></i>
                    <input type="password" name="password_confirmation" class="form-control rounded-xs"
                        id="input-password-confirmation" placeholder="********">
                    <label for="input-password-confirmation"
                        class="color-theme form-label-always-active font-10 opacity-50">Confirm Password</label>
                </div>
                <button type="submit"
                    class='btn rounded-sm btn-m gradient-blue text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s'>Simpan
                    Perubahan</button>
            </form>
        </div>
        <!-- End of Page Content-->
    @endsection
    @push('js')
        <script>
            $(document).ready(function() {
                $('#anggota').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('profil.update', $user->id) }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: formData, // Menggunakan objek FormData sebagai data
                        contentType: false, // Set contentType dan processData ke false
                        processData: false,
                        success: function(response) {
                            swal({
                                title: 'Profil Berhasil Dirubah!',
                                text: response.message,
                                icon: 'success',
                                button: 'Ok'
                            }).then(function() {
                                location.href = "{{ route('profil.index') }}";
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

                updateAge();
                $('#input-tanggal_lahir').change(function() {
                    updateAge();
                });

                function updateAge() {
                    var dob = new Date($('#input-tanggal_lahir').val());
                    var today = new Date();
                    var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                    $('#input-umur').val(age);
                }
            });
        </script>

        <script>
            // Fungsi untuk menghilangkan notifikasi setelah 10 detik
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        </script>
    @endpush
