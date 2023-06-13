@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Pelatihan</title>
@endsection
@section('content')
    <div id="page">
        <!-- Your Page Content Goes Here-->
        <div class="content">
            <div class="card card-style">
                <div class="card-body px-0 py-0">
                    <h5 class="font-700 px-3 mb-3 mt-3 text-center">{{ $events->name }}</h5>
                    <div class="divider mb-0 mx-3"></div>
                    <br>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <img src="{{ asset('images/events/' . $events->image) }}" alt="{{ $events->name }}" class="img-fluid"
                            style="max-width: 500px; max-height: 500px; ">
                        <p class="text-center">Gambar {{ $events->image }}</p>
                    </div>
                    <div class="divider mb-0 mx-3"></div>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3">
                        <p style="display: flex; justify-content: space-between; width: 100%;">Dibuat pada tanggal:
                            {{ $events->created_at->format('j F Y') }}</p>

                        {!! html_entity_decode($events->keterangan) !!}
                    </div>
                </div>
            </div>

        </div>
        <!-- End of Page Content-->
    </div>
@endsection
