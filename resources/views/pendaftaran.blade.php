@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Pendaftaran</title>
@endsection

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Menghilangkan tampilan default select */
        select.hidden-select {
            display: none;
        }
    </style>
@endpush
@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        @if (session('success'))
            <div class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0" role="alert">
                <i class="bi bi-check-circle-fill pe-2"></i>
                <strong>Selamat</strong> - Anda telah terdaftar
                <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert bg-yellow-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0"
                role="alert">
                <i class="bi bi-exclamation-circle-fill pe-2"></i>
                <strong>Perhatian</strong> - {{ session('warning') }}
                <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content">
            <div class="card card-style p-5">
                <h1 class="text-center font-800 font-30 mb-2">Pendaftaran</h1>
                <p class="text-center font-13 mt-n2 mb-3">Silahkan isi data diri anda</p>
                <form method="POST" action="{{ route('form-pendaftaran.store') }}">
                    @csrf
                    <input type="hidden" id="event_id" name="event_id" value="{{ $events->id }}" />
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-person-circle font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="nama lengkap" name="name"
                            placeholder="Nama Lengkap" value="{{ auth()->user()->name }}" required />
                        <label for="nama lengkap" class="color-theme form-label-always-active font-10 opacity-50">Nama
                            Lengkap</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-at font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="email" name="email"
                            placeholder="Email" value="{{ auth()->user()->email }}" required />
                        <label for="email" class="color-theme form-label-always-active font-10 opacity-50">Email</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-phone font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="no_hp" name="no_hp"
                            placeholder="Nomor Hp" value="{{ auth()->user()->no_hp }}" required />
                        <label for="no_hp" class="color-theme form-label-always-active font-10 opacity-50">Nomor
                            Handphone</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-mortarboard font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="pendidikan" name="pendidikan"
                            placeholder="Pendidikan" value="{{ auth()->user()->pendidikan }}" readonly />
                        <label for="pendidikan" class="color-theme form-label-always-active font-10 opacity-50">Pendidikan
                            Terakhir</label>
                    </div>

                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-person font-14"></i>
                        <select class="form-select select2" name="pekerjaan_id">
                            @foreach ($pekerjaan as $krj)
                                <option value="{{ $krj->id }}"
                                    {{ Auth::user()->pekerjaan_id == $krj->id ? 'selected' : '' }}>{{ $krj->nama }}
                                </option>
                            @endforeach
                        </select>
                        <label for="pekerjaan_id"
                            class="color-theme form-label-always-active font-10 opacity-50">pekerjaan</label>
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
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-diagram-3 font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="organisasi" name="organisasi"
                            placeholder="Organisasi" required />
                        <label for="organisasi"
                            class="color-theme form-label-always-active font-10 opacity-50">Organisasi/Komunitas</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-tags font-16"></i>
                        <!-- Ganti disabled dengan readonly -->
                        <input type="text" class="form-control rounded-xs" placeholder="Events"
                            value="{{ $events->name }}" readonly />

                        <label class="color-theme form-label-always-active font-10 opacity-50">Events</label>
                    </div>
                    <button type="submit"
                        class="btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s">Daftar</button>
                </form>
            </div>
        </div>
        <!-- End of Page Content-->
    </div>
@endsection

@push('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush
