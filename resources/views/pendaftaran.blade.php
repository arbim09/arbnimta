@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Pendaftaran</title>
@endsection
@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        @if (session('success'))
            <div class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0" role="alert">
                <i class="bi bi-check-circle-fill pe-2"></i>
                <strong>Selamat</strong> - Anda telah terdaftar
                <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert bg-yellow-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-0"
                role="alert">
                <i class="bi bi-exclamation-circle-fill pe-2"></i>
                <strong>Perhatian</strong> - {{ session('warning') }}
                <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="content">
            <div class="card card-style p-5">
                <h1 class="text-center font-800 font-30 mb-2">Pendaftaran</h1>
                <p class="text-center font-13 mt-n2 mb-3">Silahkan isi data diri anda</p>
                <form method="POST" action="{{ route('form-pendaftaran.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-person-circle font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="nama lengkap" name="name"
                            placeholder="Nama Lengkap" value="{{ auth()->user()->name }}" required />
                        <label for="nama lengkap" class="color-theme">Nama Lengkap</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-at font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="email" name="email"
                            placeholder="Email" value="{{ auth()->user()->email }}" required />
                        <label for="email" class="color-theme">Email</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-phone font-14"></i>
                        <input type="text" class="form-control rounded-xs" id="no_hp" name="no_hp"
                            placeholder="Nomor Hp" value="{{ auth()->user()->no_hp }}" required />
                        <label for="no_hp" class="color-theme">Nomor Handphone</label>
                    </div>
                    <div class="form-custom form-label form-icon mb-3">
                        <i class="bi bi-tags font-16"></i>
                        <select class="form-select select2" id="events" name="event_id" required>
                            <option value="">Pilih Events</option>
                            @foreach ($events as $ev)
                                <option value="{{ $ev->id }}">{{ substr($ev->name, 0, 100) }}</option>
                            @endforeach
                        </select>

                        <label for="events" class="color-theme form-label-always-active font-10 opacity-50">Events</label>
                    </div>
                    <button type="submit"
                        class="btn rounded-sm btn-m gradient-green text-uppercase font-700 mt-4 mb-3 btn-full shadow-bg shadow-bg-s">Daftar</button>
                </form>
            </div>
        </div>
        <!-- End of Page Content-->
    </div>
@endsection

@push('js')
    {{-- <script>
        // Fungsi untuk mengisi dropdown event berdasarkan kategori yang dipilih
        function populateEvents() {
            var categoryDropdown = document.getElementById("kategori-dropdown");
            var eventDropdown = document.getElementById("events-dropdown");
            var selectedCategoryId = categoryDropdown.value;

            // Menghapus semua options sebelumnya
            eventDropdown.innerHTML = "<option value=''>Pilih Event</option>";

            // Memeriksa apakah kategori yang dipilih ada di daftar category
            if (selectedCategoryId) {
                // Mengirim permintaan AJAX ke endpoint yang mengembalikan daftar events berdasarkan kategori
                // Gantilah URL_ENDPOINT dengan URL sebenarnya ke endpoint Anda
                var url = URL_ENDPOINT + "?category_id=" + selectedCategoryId;
                var xhr = new XMLHttpRequest();
                xhr.open("GET", url, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var events = JSON.parse(xhr.responseText);
                        // Menambahkan options baru berdasarkan events yang berelasi
                        events.forEach(function(event) {
                            var option = document.createElement("option");
                            option.value = event.id;
                            option.text = event.name;
                            eventDropdown.appendChild(option);
                        });
                    }
                };
                xhr.send();
            }
        }
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '/getEvents/' + categoryID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#events').empty();
                                $('#events').append('<option hidden>pilih Events</option>');
                                $.each(data, function(key, events) {
                                    $('select[name="events"]').append(
                                        '<option value="' + key + '">' + events
                                        .name + '</option>');
                                });
                            } else {
                                $('#events').empty();
                            }
                        }
                    });
                } else {
                    $('#events').empty();
                }
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '/getEvents/' + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var eventsDropdown = $('#events');
                            eventsDropdown.empty();
                            $.each(data, function(key, value) {
                                eventsDropdown.append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                            eventsDropdown
                                .select2(); // Inisialisasi plugin select2 setelah mengisi dropdown
                        }
                    });
                } else {
                    $('#events').empty().select2(); // Reset dan inisialisasi ulang plugin select2
                }
            });
        });
    </script>
@endpush
