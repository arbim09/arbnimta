@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Berita</title>
@endsection
@push('css')
    <style>
        .list-group .list-custom p {
            margin: 0;
            padding: 0;
        }
    </style>
@endpush
@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        <div class="content">
            <div class="card card-style">
                <div class="card-body px-0 py-0">
                    <h5 class="font-700 px-3 mb-3 mt-3 text-center">{{ $posts->title }}</h5>
                    <div class="divider mb-0 mx-3"></div>
                    <br>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <img src="{{ asset('images/posts/' . $posts->image) }}" alt="{{ $posts->title }}" class="img-fluid"
                            style="max-width: 75%; height: auto;">
                        <p class="text-center">Gambar {{ $posts->image }}</p>
                    </div>
                    <div class="divider mb-0 mx-3"></div>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3">
                        <p style="display: flex; justify-content: space-between; width: 100%;">Dibuat pada tanggal:
                            {{ $posts->created_at->format('j F Y') }}<span>Oleh: {{ $posts->penulis }}</span></p>
                        <p style="margin-bottom: 0;">{!! html_entity_decode($posts->content) !!}</p>
                    </div>

                </div>
            </div>

        </div>
        <!-- End of Page Content-->
    </div>
@endsection
