@extends('layout.backend.app', [
    'title' => 'Edit Events',
    'pageTitle' => 'Edit Events',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
    <div class="card ">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Edit Events</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Kembali ke Daftar Kategori">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" enctype="multipart/form-data" action="{{ route('events.update', $event->id) }}"
                method="POST" id="events">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="events-id" value="{{ $event->id }}">
                <div class="col-md-6">
                    <label for="input-name" class="col-sm-6 col-form-label">Nama Events</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="input-name" placeholder="Judul Berita" value="{{ $event->name }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-waktu_mulai" class="col-sm-6 col-form-label">Waktu Events</label>
                    <input type="date" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror"
                        id="input-waktu_mulai" placeholder="Nama Events"
                        value="{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('Y-m-d') }}" required>
                    @error('waktu_mulai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-is-show" class="col-sm-6 col-form-label">Daring/Luring</label>
                    <select name="ondar" id="input-is-show" class="form-control @error('ondar') is-invalid @enderror"
                        required>
                        <option value="">Pilih</option>
                        <option value="Luring" {{ $event->ondar == 'Luring' ? 'selected' : '' }}>Luring</option>
                        <option value="Daring" {{ $event->ondar == 'Daring' ? 'selected' : '' }}>Daring</option>
                    </select>
                    @error('ondar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-jam" class="col-sm-6 col-form-label">Jam Mulai</label>
                    <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror"
                        id="input-jam" placeholder="Nama Events" value="{{ $event->jam }}" required>
                    @error('jam')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-pilih_keterangan" class="col-sm-6 col-form-label">Keterangan Daring/Luring</label>
                    <input type="text" name="pilih_keterangan"
                        class="form-control @error('pilih_keterangan') is-invalid @enderror" id="input-pilih_keterangan"
                        placeholder="Masukan Link Zoom/Nama Jalan" value="{{ $event->pilih_keterangan }}" required>
                    @error('pilih_keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-category" class="col-sm-6 col-form-label">Kategori</label>
                    <select class="form-control select2" id="category" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $event->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
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
                    @if ($event->image)
                        <div class="mt-2">
                            <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->name }}"
                                style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label for="input-is-show" class="col-sm-6 col-form-label">Tampilkan event</label>
                    <select name="is_show" id="input-is-show" class="form-control @error('is_show') is-invalid @enderror"
                        required>
                        <option value="1" {{ $event->is_show == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $event->is_show == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_show')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="input-status" class="col-sm-6 col-form-label">Status Event</label>
                    <select name="status" id="input-status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="1" {{ $event->status == 1 ? 'selected' : '' }}>Berjalan</option>
                        <option value="0" {{ $event->status == 0 ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="input-keterangan" class="col-sm-6 col-form-label">Keterangan</label>
                    <div id="editor"></div>
                    <input type="hidden" name="keterangan" value="{{ $event->keterangan }}">
                    @error('keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="card-footer">
            <div class="btn-group float-right">
                <button type="button" onclick="resetForm('events')" class="btn btn-sm btn-danger">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /.card-footer-->
        </form>
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

            var keteranganInput = document.querySelector('input[name=keterangan]');
            var keterangan = keteranganInput.value;
            quill.clipboard.dangerouslyPasteHTML(keterangan);

            var form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                var html = quill.root.innerHTML;
                keteranganInput.value = html;
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#events').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var id = $('#events-id').val(); // Ambil nilai ID post dari input tersembunyi
                    $.ajax({
                        url: '{{ route('events.update', ':id') }}'.replace(':id',
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
