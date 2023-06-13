@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Acara</title>
@endsection

@section('content')
    <div class="page">
        <div class="card card-style">
            <div class="content mb-0">
                <h1 class="pb-2">List Acara</h1>
                <div class="acaraContainer" id="acaraContainer">
                    @foreach ($events as $event)
                        <br>
                        <a href="{{ route('show.acara', $event->id) }}">
                            <div class="d-flex mb-3">
                                <div class="align-self-center me-auto">
                                    <h5 class="font-500 font-15 pb-1">{{ substr($event->name, 0, 30) }}...</h5>
                                    <span
                                        class="color-theme font-10 ps-2 opacity-50">{{ date('j F Y', strtotime($event->created_at)) }}</span>
                                </div>
                                <div class="align-self-start ms-auto">
                                    <img src="{{ asset('images/events/' . $event->image) }}" class="rounded-m ms-3"
                                        width="90">
                                </div>
                            </div>
                        </a>
                        <br>
                        <div class="divider mb-3"></div>
                    @endforeach
                </div>
                @if ($events->hasMorePages())
                    <div class="text-center">
                        <a href="{{ route('load-more-acara') }}" id="loadMoreButton"
                            class="btn-full btn btn-block bg-blue-dark">Lihat Lainnya</a>
                    </div>
                @else
                    <div class="text-center">
                        <p>Tidak ada Acara lain yang tersedia.</p>
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
        var acaraContainer = document.getElementById('acaraContainer');

        loadMoreButton.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage++;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ route('load-more-acara') }}" + "?page=" + currentPage, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    var parser = new DOMParser();
                    var newAcara = parser.parseFromString(response, 'text/html').querySelector(
                        '#acaraContainer');
                    acaraContainer.innerHTML += newAcara.innerHTML;
                }
            };
            xhr.send();
        });
    </script>
@endpush
