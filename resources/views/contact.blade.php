@extends('layout.anggotaLayouts.main')
@section('title')
  <title>Kontak Kami</title>
@endsection
@section('content')
    <!-- Your Page Content Goes Here-->
        <div class="content">
            <div class="card p-5">
                <h1 class="pb-2">Hubungi Kami</h1>
            <div class="divider"></div>
            <form action="{{ route('send.email') }}" method="POST">
                @csrf
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-person-circle font-14"></i>
                    <input type="text" class="form-control rounded-xs" id="name" name="name" placeholder="Nama" value="{{ old('name') }}"/>
                    <label for="name" class="color-theme form-label-always-active font-10 opacity-50">Name</label>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-at font-16"></i>
                    <input type="email" class="form-control rounded-xs" id="email" name="email" placeholder="Email" value="{{ old('email') }}"/>
                    <label for="email" class="color-theme form-label-always-active font-10 opacity-50">Email</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-phone font-16"></i>
                    <input type="text" class="form-control rounded-xs" id="no_hp" name="no_hp" placeholder="0831467562123" value="{{ old('no_hp') }}"/>
                    <label for="no_hp" class="color-theme form-label-always-active font-10 opacity-50">Telephone</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-bookmark-check font-16"></i>
                    <input type="text" class="form-control rounded-xs" id="subject" name="subject" placeholder="Subject" value="{{ old('subject') }}"/>
                    <label for="subject" class="color-theme form-label-always-active font-10 opacity-50">Subject</label>
                    <span>(required)</span>
                </div>
                <div class="form-custom form-label form-icon mb-3">
                    <i class="bi bi-chat-right-dots font-16"></i>
                    <textarea class="form-control rounded-xs" id="message" name="message" placeholder="Pesan">{{ old('message') }}</textarea>
                    <label for="message" class="color-theme form-label-always-active font-10 opacity-50">Pesan</label>
                    <span>(required)</span>
                </div>
                <button type="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green-dark text-uppercase font-900 mt-4">Kirim</button>
            </form>
            </div>
        </div>
	<!-- End of Page Content-->
@endsection