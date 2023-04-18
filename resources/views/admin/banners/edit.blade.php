@extends('layout.backend.app',[
    'title' => 'Edit Banner',
    'pageTitle' =>'Edit Banner',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card ">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Edit Banner</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('banners.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Kategori">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
      </div>
      <div class="card-body">
        <form class="row g-3" enctype="multipart/form-data" action="{{route('banners.update', $banners->id)}}" method="POST" id="banners">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="banner-id" value="{{ $banners->id }}">
            <div class="col-md-6">
                <label for="input-name" class="col-sm-6 col-form-label">Nama Banner</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Judul Berita" value="{{ $banners->name }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="input-author" class="col-sm-6 col-form-label">Pembuat</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="input-author" placeholder="Judul Berita" value="{{ $banners->author }}" required>
                @error('author')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="input-image" class="col-sm-6 col-form-label">Banner</label>
                <input type="file" id="image" name="image" class="form-control col-sm-6" id="input-image" placeholder="image" value="{{ old('image') }}" >
                @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                @if ($banners->image)
                <div class="mt-2">
                    <img src="{{ asset('images/banners/'.$banners->image) }}" alt="{{ $banners->name }}" width="600">
                </div>
                @endif
            </div>
            <div class="col-md-6">
                <label for="input-is-show" class="col-sm-6 col-form-label">Status</label>
                <select name="is_show" id="input-is-show" class="form-control @error('is_show') is-invalid @enderror" required>
                    <option value="1" {{ $banners->is_show == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $banners->is_show == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_show')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
    </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group float-right">
                    <button type="button" onclick="resetForm('banners')" class="btn btn-sm btn-danger">Reset</button>
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
        $('#banners').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#banner-id').val(); // Ambil nilai ID banner dari input tersembunyi
            $.ajax({
                url: '{{ route('banners.update', ':id') }}'.replace(':id', id), // Gunakan route update dan isi ID banner yang akan diupdate
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    swal({
                        title: 'Data Berhasil Disimpan!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('banners.index') }}";
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