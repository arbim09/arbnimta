@extends('layout.backend.app',[
    'title' => 'Edit Events',
    'pageTitle' =>'Edit Events',
])

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card ">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Edit Events</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('event.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Kategori">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
      </div>
    <div class="card-body">
    <form class="row g-3" enctype="multipart/form-data" action="{{ route('event.update', $event->id) }}" method="POST" id="events">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="events-id" value="{{ $event->id }}">
        <div class="col-md-6">
            <label for="input-name" class="col-sm-6 col-form-label">Nama Events</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Judul Berita" value="{{ $event->name }}" required>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="input-category" class="col-sm-6 col-form-label">Kategori</label>
            <select class="form-control select2" id="category" name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="input-image" class="col-sm-6 col-form-label">Gambar</label>
            <input type="file" id="image" name="image" class="form-control col-sm-6" id="input-image" placeholder="image" value="{{ old('image') }}">
            @error('image')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            @if ($event->image)
            <div class="mt-2">
                <img src="{{ asset('images/events/'.$event->image) }}" alt="{{ $event->name }}" width="600">
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <label for="input-is-show" class="col-sm-6 col-form-label">Status</label>
            <select name="is_show" id="input-is-show" class="form-control @error('is_show') is-invalid @enderror" required>
                <option value="1" {{ $event->is_show == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $event->is_show == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('is_show')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="input-keterangan" class="col-sm-6 col-form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" style="resize: vertical;" required>{{ $event->keterangan }}</textarea>
            @error('keterangan')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
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
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('#events').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#events-id').val(); // Ambil nilai ID post dari input tersembunyi
            $.ajax({
                url: '{{ route('event.update', ':id') }}'.replace(':id', id), // Gunakan route update dan isi ID post yang akan diupdate
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
                        location.href = "{{ route('event.index') }}";
                    });
                },
                error: function(response) {
                    swal({
                        title: 'Data Berhasil Disimpan!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('event.index') }}";
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