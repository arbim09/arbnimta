@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Kegiatan</title>
@endsection
@section('content')
    <div id="page">
        <div class="content">
            <div class="card card-style">
                <div class="card-body px-0 py-0">
                    <div class="divider mb-0 mx-3"></div>
                    <h5 class="font-700 px-3 mb-3 mt-3 text-center">{{ $events->name }}</h5>
                    <div class="divider mb-0 mx-3"></div>
                    <div class="divider mb-0 mx-3"></div>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <img src="{{ asset('images/events/' . $events->image) }}" alt="{{ $events->name }}"
                            class="img-fluid" style="max-width: 500px; max-height: 500px; ">
                    </div>
                    <div class="divider mb-0 mx-3"></div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-left: 5px;">
                        <span
                            class="badge bg-blue-dark shadow-bg shadow-bg-xs text-uppercase p-2 px-3 rounded-s my-3">{{ $events->ondar }}</span>
                        <br>
                    </div>
                    <div class="list-group list-custom list-group-m rounded-xs list-group-flush px-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p style="margin: 0;">Dimulai pada tanggal: {{ date('j F Y', strtotime($events->waktu_mulai)) }}
                            </p>
                            <p style="margin: 0;">Jam: {{ substr($events->jam, 0, 5) }}</p>
                        </div>
                        <br>

                        {!! html_entity_decode($events->keterangan) !!}
                        @if ($events->ondar === 'Daring')
                            <p>Link Zoom: <a href="{{ $events->pilih_keterangan }}"></a>{{ $events->pilih_keterangan }}</p>
                        @else
                            <p>Dilaksanaan di: {{ $events->pilih_keterangan }}</p>
                        @endif

                        <br>
                    </div>
                </div>
            </div>

        </div>
        <!-- End of Page Content-->
    </div>
@endsection
