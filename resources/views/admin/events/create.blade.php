@extends('layout.backend.app', [
    'title' => 'Tambah Events',
    'pageTitle' => 'Tambah Events',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
    <div class="card ">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Tambah Events</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Kembali ke Daftar Kategori">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" enctype="multipart/form-data" action="{{ route('events.store') }}" method="POST"
                id="events">
                @csrf
                <div class="col-md-6">
                    <label for="input-name" class="col-sm-6 col-form-label">Nama Events</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="input-name" placeholder="Nama Events" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-waktu_mulai" class="col-sm-6 col-form-label">Waktu Events</label>
                    <input type="date" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror"
                        id="input-waktu_mulai" placeholder="Nama Events" value="{{ old('waktu_mulai') }}" required>
                    @error('waktu_mulai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-jam" class="col-sm-6 col-form-label">Jam Mulai</label>
                    <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror"
                        id="input-jam" placeholder="Nama Events" value="{{ old('jam') }}" required>
                    @error('jam')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-is-show" class="col-sm-6 col-form-label">Daring/Luring</label>
                    <select name="ondar" id="input-is-show" class="form-control @error('ondar') is-invalid @enderror"
                        required>
                        <option value="Luring">Luring</option>
                        <option value="Daring">Daring</option>
                    </select>
                    @error('ondar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-pilih_keterangan" class="col-sm-6 col-form-label">Keterangan Daring/Luring</label>
                    <input type="text" name="pilih_keterangan"
                        class="form-control @error('pilih_keterangan') is-invalid @enderror" id="input-pilih_keterangan"
                        placeholder="Masukan link zoom/meet atau nama jalan/tempat" value="{{ old('pilih_keterangan') }}"
                        required>
                    @error('pilih_keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-category" class="col-sm-6 col-form-label">Kategori</label>
                    <select class="form-control" id="category" name="category_id">
                        @foreach ($category_id as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-image" class="col-sm-6 col-form-label">Gambar</label>
                    <input type="file" id="image" name="image" class="form-control col-sm-6" id="input-image"
                        placeholder="image" value="{{ old('image') }}">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-is-show" class="col-sm-6 col-form-label">Status</label>
                    <select name="is_show" id="input-is-show" class="form-control @error('is_show') is-invalid @enderror"
                        required>
                        <option value="1" {{ old('is_show') == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_show') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_show')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input-keterangan" class="col-sm-6 col-form-label">Keterangan</label>
                    <div id="editor"></div>
                    <input type="hidden" name="keterangan">
                    @error('keterangan')
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
                <button type="button" onclick="resetForm('events')" class="btn btn-sm btn-danger">Reset</button>
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
        var form = document.querySelector('form');
        form.onsubmit = function() {
            var keterangan = document.querySelector('input[name=keterangan]');
            keterangan.value = quill.root.innerHTML;
        };
    </script>
    <script>
        $(document).ready(function() {
            $('#events').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('events.store') }}',
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
                            location.href = "{{ route('events.index') }}";
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
