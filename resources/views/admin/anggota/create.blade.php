@extends('layout.backend.app',[
    'title' => 'Tambah Anggota',
    'pageTitle' =>'Tambah Anggota',
])

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Warga">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-3" action="{{route('anggota.store')}}" method="POST" id="anggota">
            @csrf
            <div class="col-md-4">
                <label for="input-name" class="col-sm-6 col-form-label text-danger">Nama Lengkap{!! printRequired() !!}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-email" class="col-sm-4 col-form-label text-danger">Email</label>
                <div class="">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="input-email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-no_hp" class="col-sm-4 col-form-label">Telepon</label>
                <div class="">
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="input-no_hp" placeholder="08...." value="{{ old('no_hp') }}">
                    @error('no_hp')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-jenis_kelamin" class="mb-2 col-sm-6 col-form-label text-danger">Jenis Kelamin{!! printRequired() !!}</label><br/>
                <div class="">
                    <input type="radio" id="Male" name="jenis_kelamin" value="Laki-laki"> Laki-Laki  
                    <input type="radio" id="Female" name="jenis_kelamin" value="Perempuan" class=" ml-2"> Perempuan  
                </div>
                    @error('jenis_kelamin')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="input-tempat_lahir" class="col-sm-6 col-form-label text-danger">Tempat Lahir</label>
                <div class="">
                    <input type="tempat_lahir" name="tempat_lahir" class="form-control" id="input-tempat_lahir" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
                    @error('tempat_lahir')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-tanggal_lahir" class="col-sm-6 col-form-label text-danger">Tanggal Lahir</label>
                <div class="">
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="input-tanggal_lahir" placeholder="Birth Date" value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password" class="col-sm-4 col-form-label text-danger">Password</label>
                <div class="">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="input-password" placeholder="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password_confirmation" class="col-sm-6 col-form-label text-danger">Konfirmasi Password</label>
                <div class="">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="col-md-8">
                <label for="input-alamat" class="col-sm-8 col-form-label text-danger">Alamat Lengkap Domisili{!! printRequired() !!}</label>
                <div class="">
                    <textarea type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="input-alamat" placeholder="Bisa diisi nama jalan atau RT / RW" value="{{ old('alamat') }}"></textarea>
                    @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
    </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group float-right">
                    <button type="button" onclick="formReset()" class="btn btn-sm btn-danger">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /.card-footer-->
    </form>
</div>
@endsection


@push('js')
<script>
    $(document).ready(function() {
        $('#anggota').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('anggota.store') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#anggota').serialize(),
                success: function(response) {
                    swal({
                        title: 'Data Berhasil Disimpan!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('anggota.index') }}";
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
    });
</script>
@endpush