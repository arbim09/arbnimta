@extends('layout.backend.app', [
    'title' => 'Tambah Dokumentasi',
    'pageTitle' => 'Tambah Dokumentasi',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Upload Dokumentasi</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Kembali ke Daftar Kategori">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" enctype="multipart/form-data" action="{{ route('dokumentasi.store') }}" method="POST"
                id="dokumentasi">
                @csrf
                <div class="col-md-6">
                    <label for="events" class="col-sm-8 col-form-label">Events</label>
                    <select class="form-control select2" id="events" name="event_id" required>
                        <option value="">Pilih Events</option>
                        @foreach ($events as $ev)
                            <option value="{{ $ev->id }}">{{ $ev->name }}</option>
                            {{-- <option value="{{ $ev->id }}">{{ $ev->name }}</option> --}}
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="input-gambar1" class="col-sm-6 col-form-label">Gambar1</label>
                    <input type="file" id="gambar1" name="gambar1" class="form-control col-sm-12" id="input-gambar1"
                        placeholder="gambar1" value="{{ old('gambar1') }}" required>
                    @error('gambar1')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-gambar2" class="col-sm-6 col-form-label">Gambar2</label>
                    <input type="file" id="gambar2" name="gambar2" class="form-control col-sm-12" id="input-gambar2"
                        placeholder="gambar2" value="{{ old('gambar2') }}">
                    @error('gambar2')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-gambar3" class="col-sm-6 col-form-label">Gambar3</label>
                    <input type="file" id="gambar3" name="gambar3" class="form-control col-sm-12" id="input-gambar3"
                        placeholder="gambar3" value="{{ old('gambar3') }}">
                    @error('gambar3')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-gambar4" class="col-sm-6 col-form-label">Gambar4</label>
                    <input type="file" id="gambar4" name="gambar4" class="form-control col-sm-12" id="input-gambar4"
                        placeholder="gambar4" value="{{ old('gambar4') }}">
                    @error('gambar4')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-gambar5" class="col-sm-6 col-form-label">Gambar5</label>
                    <input type="file" id="gambar5" name="gambar5" class="form-control col-sm-12" id="input-gambar5"
                        placeholder="gambar5" value="{{ old('gambar5') }}">
                    @error('gambar5')
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
                <button type="button" onclick="resetForm('dokumentasi')" class="btn btn-sm btn-danger">Reset</button>
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
        $(document).ready(function() {
            $('#dokumentasi').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('dokumentasi.store') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: 'Data Dokumentasi Berhasil Disimpan!',
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
