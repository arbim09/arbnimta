@extends('layout.backend.app', [
    'title' => 'Edit Contact',
    'pageTitle' => 'Edit Contact',
])

@section('content')
<div class="card ">
    <div class="card-header d-flex align-items-center">
        <h5 class="card-title">Edit Contact</h5>
        <div class="card-tools ml-auto mr-0">
            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Kembali ke Daftar Contact">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-3" action="{{ route('contact.update', $contact->id) }}" method="POST" id="contact">
            @csrf
            @method('PUT')
            <div class="col-md-4">
                <label for="input-name" class="col-sm-6 col-form-label">Nama</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input-name" placeholder="Nama" value="{{ $contact->name }}" readonly>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-email" class="col-sm-6 col-form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="input-email" placeholder="Email" value="{{ $contact->email }}" readonly>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-phone" class="col-sm-6 col-form-label">Telepon</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="input-phone" placeholder="Telepon" value="{{ $contact->phone }}" readonly>
                @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-subject" class="col-sm-6 col-form-label">Subject</label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" id="input-subject" placeholder="Telepon" value="{{ $contact->subject }}" readonly>
                @error('subject')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="input-status" class="mt-2 col-sm-6 col-form-label">Status</label><br/>
                    <input type="radio" id="read" name="status" value="1" {{ $contact->is_read ? 'checked' : '' }}> Sudah Dibaca
                    <input type="radio" class="ml-2" id="unread" name="status" value="0" {{ !$contact->is_read ? 'checked' : '' }}> Belum Dibaca
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="input-message" class="col-sm-6 col-form-label">Pesan</label>
                <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="input-message" placeholder="Pesan" readonly>{{ $contact->message }}</textarea>
                @error('message')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="btn-group float-right">
            <button type="button" onclick="resetForm('contact')" class="btn btn-sm btn-danger">Reset</button>
            <button type="submit" class="btn btn-sm btn-primary" form="contact">Simpan</button>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.card-footer-->
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#contact').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('contact.update', $contact->id) }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#contact').serialize(),
                success: function(response) {
                    swal({
                        title: 'Data Berhasil Disimpan!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('contact.index') }}";
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

        updateAge();
        $('#input-tanggal_lahir').change(function() {
            updateAge();
        });

        function updateAge() {
            var dob = new Date($('#input-tanggal_lahir').val());
            var today = new Date();
            var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
            $('#input-umur').val(age);
        }
    });
</script>
@endpush