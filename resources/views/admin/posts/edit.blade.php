@extends('layout.backend.app', [
    'title' => 'Edit Berita',
    'pageTitle' => 'Edit Berita',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="card ">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Edit Berita</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('posts.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Kembali ke Daftar Kategori">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" enctype="multipart/form-data" action="{{ route('posts.update', $posts->id) }}"
                method="POST" id="posts">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="posts-id" value="{{ $posts->id }}">
                <div class="col-md-6">
                    <label for="input-title" class="col-sm-6 col-form-label">Judul Berita</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        id="input-title" placeholder="Judul Berita" value="{{ old('title', $posts->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-penulis" class="col-sm-6 col-form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
                        id="input-penulis" placeholder="Judul Berita" value="{{ old('penulis', $posts->penulis) }}"
                        required>
                    @error('penulis')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-category" class="col-sm-6 col-form-label">Kategori</label>
                    <select class="form-control select2" id="category" name="category_id">
                        @foreach ($category_id as $category)
                            <option value="{{ $category->id }}" @if ($posts->category_id == $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input-image" class="col-sm-6 col-form-label">Gambar</label>
                    <input type="file" id="image" name="image" class="form-control col-sm-6" id="input-image"
                        placeholder="image" value="{{ old('image') }}">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($posts->image)
                        <div class="mt-2">
                            <img src="{{ asset('images/posts/' . $posts->image) }}" alt="{{ $posts->name }}"
                                width="200">
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <label for="input-content" class="col-sm-6 col-form-label">Isi Berita</label>
                    <div id="editor"></div>
                    <input type="hidden" name="content" value="{{ $posts->content }}">
                    @error('content')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

        </div>
        <br>
        <br>
        <br>
        <br>
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
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        var contentInput = document.querySelector('input[name=content]');
        var content = contentInput.value;
        quill.clipboard.dangerouslyPasteHTML(content);

        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            var html = quill.root.innerHTML;
            contentInput.value = html;
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#posts').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#posts-id').val(); // Ambil nilai ID post dari input tersembunyi
                $.ajax({
                    url: '{{ route('posts.update', ':id') }}'.replace(':id',
                        id), // Gunakan route update dan isi ID post yang akan diupdate
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
