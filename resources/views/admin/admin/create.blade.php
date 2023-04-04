@extends('layout.backend.app',[
    'title' => 'Tambah Kategori',
    'pageTitle' =>'Tambah Kategori',
])

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Tambah Kategori</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('kategori.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Kategori">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
      </div>
    <div class="card-body">
        <form class="row g-3" action="{{route('kategori.store')}}" method="POST" id="kategori">
            @csrf
            <div class="col-md-4">
                <label for="input-name" class="col-sm-6 col-form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-email" class="col-sm-4 col-form-label">Email</label>
                <div class="">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="input-email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password" class="col-sm-4 col-form-label">Password</label>
                <div class="">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="input-password" placeholder="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <label for="input-password_confirmation" class="col-sm-6 col-form-label">Konfirmasi Password</label>
                <div class="">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
    </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group float-right">
                    <button type="button" onclick="resetForm('kategori')" class="btn btn-sm btn-danger">Reset</button>
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
        $('#kategori').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('kategori.store') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#kategori').serialize(),
                success: function(response) {
                    swal({
                        title: 'Data Berhasil Disimpan!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('kategori.index') }}";
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


    function resetForm(formId) {
        document.getElementById(formId).reset();
    }
</script>
@endpush