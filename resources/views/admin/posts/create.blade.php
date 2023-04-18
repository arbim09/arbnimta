@extends('layout.backend.app',[
    'title' => 'Tambah Berita',
    'pageTitle' =>'Tambah Berita',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card ">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Tambah Berita</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('posts.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Kategori">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
      </div>
    <div class="card-body">
        <form class="row g-3" enctype="multipart/form-data" action="{{route('posts.store')}}" method="POST" id="posts">
            @csrf
            <div class="col-md-6">
                <label for="input-title" class="col-sm-6 col-form-label">Judul Berita</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="input-title" placeholder="Judul Berita" value="{{ old('title') }}" required>
                @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="input-penulis" class="col-sm-6 col-form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror" id="input-penulis" placeholder="Judul Berita" value="{{ Auth::user()->name }}" required>
                @error('penulis')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="input-category" class="col-sm-6 col-form-label">Kategori</label>
                <select class="form-control select2" id="category" name="category_id">
                    @foreach($category_id as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="input-image" class="col-sm-6 col-form-label">Gambar</label>
                <input type="file" id="image" name="image" class="form-control col-sm-6" id="input-image" placeholder="image" value="{{ old('image') }}" >
                @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="input-content" class="col-sm-6 col-form-label">Isi Berita</label>
                <textarea class="form-control" id="content" name="content" rows="5" style="resize: vertical;" required></textarea>
                @error('content')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
    </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group float-right">
                    <button type="button" onclick="resetForm('posts')" class="btn btn-sm btn-danger">Reset</button>
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
        $('#posts').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('posts.store') }}',
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
                        location.href = "{{ route('posts.index') }}";
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