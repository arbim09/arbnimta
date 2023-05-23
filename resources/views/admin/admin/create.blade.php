@extends('layout.backend.app',[
    'title' => 'Tambah User',
    'pageTitle' =>'Tambah User',
])
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar User">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-3" action="{{route('admin.store')}}" method="POST" id="admin">
            @csrf
            <div class="col-md-4">
                <label for="input-name" class="col-sm-6 col-form-label text-danger">Nama Lengkp{!! printRequired() !!}</label>
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
            <div class="col-md-4 d-none">
                <label for="input-umur" class="col-sm-6 col-form-label text-danger">Umur</label>
                <div class="">
                    <input type="text" name="umur" class="form-control" id="input-umur" placeholder="Umur" readonly>
                    @error('umur')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-pendidikan" class="col-sm-6 col-form-label text-danger">Pendidikan</label>
                <div class="">
                    <select type="pendidikan" name="pendidikan" class="form-control" id="input-pendidikan" placeholder="pendidikan" value="{{ old('pendidikan') }}">
                        <option value="" selected disabled>Pendidikan</option>
                        @foreach(App\Models\User::getPendidikan('users', 'pendidikan') as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('pendidikan')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-agama" class="col-sm-6 col-form-label text-danger">Agama</label>
                <div class="">
                    <select type="agama" name="agama" class="form-control" id="input-agama" placeholder="agama" value="{{ old('agama') }}">
                        @foreach(App\Models\User::getAgama('users', 'agama') as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('agama')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-pekerjaan" class="col-sm-6 col-form-label">Pekerjaan</label>
                <select class="form-control select2" id="pekerjaan" name="pekerjaan_id">
                    @foreach($kerja as $pkr)
                        <option value="{{ $pkr->id }}">{{ $pkr->nama }}</option>
                    @endforeach
                </select>
                @error('pekerjaan')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-role" class="col-sm-6 col-form-label text-danger">Role</label>
                <div class="">
                    <select type="role" name="role" class="form-control" id="input-role" placeholder="Role" value="{{ old('role') }}">
                        @foreach(App\Models\User::getEnumValues('users', 'role') as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-foto_profil" class="col-sm-6 col-form-label">Foto Profil</label>
                <input type="file" id="foto_profil" name="foto_profil" class="form-control" id="input-foto_profil" placeholder="foto_profil" value="{{ old('foto_profil') }}">
                @error('foto_profil')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
$(document).ready(function() {
    $('#admin').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this); // Buat objek FormData untuk menyimpan data form
        
        $.ajax({
            url: '{{ route('admin.store') }}',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            processData: false, // Jangan memproses data secara otomatis
            contentType: false, // Jangan mengatur tipe konten secara otomatis
            success: function(response) {
                swal({
                    title: 'Data Berhasil Disimpan!',
                    text: response.message,
                    icon: 'success',
                    button: 'Ok'
                }).then(function() {
                    location.href = "{{ route('admin.index') }}";
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
    
    $('#input-tanggal_lahir').change(function() {
        var dob = new Date($(this).val());
        var today = new Date();
        var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#input-umur').val(age);
    });
});
</script>
@endpush