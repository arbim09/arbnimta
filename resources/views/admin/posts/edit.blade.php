@extends('layout.backend.app',[
    'title' => 'Edit Admin',
    'pageTitle' =>'Edit Admin',
])

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Edit Admin</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Admin">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-3" action="{{route('admin.update', $admin->id)}}" method="POST" id="admin">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" value="{{ $admin->id }}">
            <div class="col-md-4">
                <label for="input-name" class="col-sm-6 col-form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Nama Lengkap" value="{{ $admin->name }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-email" class="col-sm-4 col-form-label">Email</label>
                <div class="">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="input-email" placeholder="Email" value="{{ $admin->email }}">
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password" class="col-sm-4 col-form-label">Password</label>
                <div class="">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="input-password" placeholder="password"  maxlength="8" size="8">
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password_confirmation" class="col-sm-6 col-form-label">Konfirmasi Password</label>
                <div class="">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
            </div>
    </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group float-right">
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
        $('#admin').submit(function(e) {
            e.preventDefault();
            var id = $('#id').val(); // Ambil ID admin dari input tersembunyi
            $.ajax({
                url: '{{ route('admin.update', ':id') }}'.replace(':id', id), // Set endpoint URL dengan ID admin menggunakan route
                type: 'PUT',
                dataType: 'JSON',
                data: $('#admin').serialize(),
                success: function(response) {
                    swal({
                        title: 'Data Berhasil Diupdate!',
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
    });
</script>
@endpush