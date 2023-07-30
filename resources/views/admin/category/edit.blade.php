@extends('layout.backend.app', [
    'title' => 'Edit Kategori',
    'pageTitle' => 'Edit Kategori',
])

@section('content')
    <div class="card ">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Edit Kategori</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Kembali ke Daftar Kategori">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" action="{{ route('category.update', $category->id) }}" method="POST" id="category">
                @csrf
                @method('PUT')
                <div class="col-md-4">
                    <label for="input-name" class="col-sm-6 col-form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="input-name" placeholder="Nama Kategori" value="{{ $category->name }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="btn-group float-right">
                <button type="button" onclick="resetForm('category')" class="btn btn-sm btn-danger">Reset</button>
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
            $('#category').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('category.update', $category->id) }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: $('#category').serialize(),
                    success: function(response) {
                        swal({
                            title: 'Data Berhasil Disimpan!',
                            text: response.message,
                            icon: 'success',
                            button: 'Ok'
                        }).then(function() {
                            location.href = "{{ route('category.index') }}";
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
