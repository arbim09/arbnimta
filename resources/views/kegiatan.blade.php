@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Kegiatan</title>
@endsection

@section('content')
    <div class="page">
        <div class="card card-style">

            <div class="content mb-0">
                <h1 class="pb-2">List Kegiatan</h1>
                <div class="kegiatanContainer" id="kegiatanContainer">
                    @foreach ($events as $event)
                        <br>
                        <a href="{{ route('show.kegiatan', $event->id) }}">
                            <div class="d-flex mb-3">
                                <div class="align-self-center me-auto">
                                    <h5 class="font-500 font-15 pb-1">{{ $event->name }}</h5>
                                    <span class="color-theme font-15 ps-2 opacity-50"><i class="bi bi-calendar font-16"></i>
                                        Waktu:
                                        {{ date('j F Y', strtotime($event->waktu_mulai)) }}</span>
                                    <div>
                                        <span class="color-theme font-15 ps-2 opacity-50"><i
                                                class="bi bi-clock font-16"></i> Pukul: {{ $event->jam }}</span>
                                    </div>
                                    <div>
                                        @if ($event->status)
                                            <span class="ps-3 pb-1 pt-3 font-13 color-highlight">Event Sedang
                                                Berjalan</span>
                                        @else
                                            <span class="ps-3 pb-1 pt-3 font-13 color-highlight">Event Telah Selesai</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="align-self-start ms-auto">
                                    <div style="max-width: 300px; max-height: 400px;">
                                        <img src="{{ asset('images/events/' . $event->image) }}" class="rounded-m ms-3"
                                            style="width: 100%; height: 100%;">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <br>
                        <div class="divider mb-3"></div>
                    @endforeach
                </div>
                @if ($events->hasMorePages())
                    <div class="text-center">
                        <a href="{{ route('load-more-kegiatan') }}" id="loadMoreButton"
                            class="btn-full btn btn-block bg-blue-dark">Lihat Lainnya</a>
                    </div>
                @else
                    <div class="text-center">
                        <p>Tidak ada pelatihan lain yang tersedia.</p>
                        <script>
                            var loadMoreButton = document.getElementById('loadMoreButton');
                            if (loadMoreButton) {
                                loadMoreButton.style.display = 'none';
                            }
                        </script>
                    </div>
                @endif
                <br>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var currentPage = 1;
        var loadMoreButton = document.getElementById('loadMoreButton');
        var kegiatanContainer = document.getElementById('kegiatanContainer');

        loadMoreButton.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage++;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ route('load-more-kegiatan') }}" + "?page=" + currentPage, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    var parser = new DOMParser();
                    var newKegiatan = parser.parseFromString(response, 'text/html').querySelector(
                        '#kegiatanContainer');
                    kegiatanContainer.innerHTML += newKegiatan.innerHTML;
                }
            };
            xhr.send();
        });
    </script>
@endpush
