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
            <form class="row g-3" enctype="multipart/form-data" action="{{ route('dokumentasi.update', $dokumentasi->id) }}"
                id="dokumentasi" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="dokumentasi_id" id="dokumentasi_id" value="{{ $dokumentasi->id }}">
                <div class="col-md-6">
                    <label for="events" class="col-sm-8 col-form-label">Events</label>
                    <select class="form-control select2" id="events" name="event_id" required>
                        <option value="">Pilih Events</option>
                        @foreach ($events as $ev)
                            <option value="{{ $ev->id }}" {{ $ev->id == $dokumentasi->event_id ? 'selected' : '' }}>
                                {{ $ev->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="gambar1" class="col-sm-6 col-form-label">Gambar1</label>
                    <input type="file" id="gambar1" name="gambar1" class="form-control col-sm-12"
                        placeholder="gambar1">
                    @error('gambar1')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($dokumentasi->gambar1)
                        <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar1) }}" alt="Gambar1" class="mt-2"
                            style="max-width: 200px">
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="gambar2" class="col-sm-6 col-form-label">Gambar2</label>
                    <input type="file" id="gambar2" name="gambar2" class="form-control col-sm-12"
                        placeholder="gambar2">
                    @error('gambar2')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($dokumentasi->gambar2)
                        <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar2) }}" alt="Gambar2" class="mt-2"
                            style="max-width: 200px">
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="gambar3" class="col-sm-6 col-form-label">Gambar3</label>
                    <input type="file" id="gambar3" name="gambar3" class="form-control col-sm-12"
                        placeholder="gambar3">
                    @error('gambar3')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($dokumentasi->gambar3)
                        <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar3) }}" alt="Gambar3" class="mt-2"
                            style="max-width: 200px">
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="gambar4" class="col-sm-6 col-form-label">Gambar4</label>
                    <input type="file" id="gambar4" name="gambar4" class="form-control col-sm-12"
                        placeholder="gambar4">
                    @error('gambar4')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($dokumentasi->gambar4)
                        <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar4) }}" alt="Gambar4" class="mt-2"
                            style="max-width: 200px">
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="gambar5" class="col-sm-6 col-form-label">Gambar5</label>
                    <input type="file" id="gambar5" name="gambar5" class="form-control col-sm-12"
                        placeholder="gambar5">
                    @error('gambar5')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($dokumentasi->gambar5)
                        <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar5) }}" alt="Gambar5" class="mt-2"
                            style="max-width: 200px">
                    @endif
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="btn-group float-right">
                <button type="button" onclick="resetForm('dokumentasi')" class="btn btn-sm btn-danger">Reset</button>
                <button type="submit" form="dokumentasi" class="btn btn-sm btn-primary">Submit</button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>


    <script>
        $(document).ready(function() {
            $('#dokumentasi').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#dokumentasi_id').val(); // Ambil nilai ID banner dari input tersembunyi
                $.ajax({
                    url: '{{ route('dokumentasi.update', ':id') }}'.replace(':id', id),
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
