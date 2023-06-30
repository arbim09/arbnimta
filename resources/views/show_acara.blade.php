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
                    <h5 class="font-700 px-3 mb-3 mt-3 text-center">
                        {{ $events->name }}
                        @if ($events->status)
                            <span class="ps-3 pb-1 pt-3 font-13 color-highlight">Event Sedang Berjalan</span>
                        @else
                            <span class="ps-3 pb-1 pt-3 font-13 color-highlight">Event Telah Selesai</span>
                        @endif
                    </h5>
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
            @if ($events->status == 0)
                <div class="card card-style">
                    <div class="content mb-0">
                        <h3 class="font-18 mb-1">Dokumentasi {{ $events->name }}</h3>
                        <div class="row text-center row-cols-3 mb-0">
                            <a class="col" data-gallery="gambar-1" href="#" title="Model Portrait">
                                <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar1) }}"
                                    class="preload-img img-fluid rounded-xs" alt="img"
                                    style="max-width: 400px; max-height: 400px; ">
                            </a>
                            <a class="col" data-gallery="gambar-1" href="#" title="Model Portrait">
                                <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar2) }}"
                                    class="preload-img img-fluid rounded-xs" alt="img"
                                    style="max-width: 400px; max-height: 400px; ">
                            </a>
                            <a class="col" data-gallery="gambar-1" href="#" title="Model Portrait">
                                <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar3) }}"
                                    class="preload-img img-fluid rounded-xs" alt="img"
                                    style="max-width: 400px; max-height: 400px; ">
                            </a>
                            <a class="col" data-gallery="gambar-1" href="#" title="Model Portrait">
                                <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar4) }}"
                                    class="preload-img img-fluid rounded-xs" alt="img"
                                    style="max-width: 400px; max-height: 400px; ">
                            </a>
                            <a class="col" data-gallery="gambar-1" href="#" title="Model Portrait">
                                <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar5) }}"
                                    class="preload-img img-fluid rounded-xs" alt="img"
                                    style="max-width: 400px; max-height: 400px; ">
                            </a>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
            @endif
        </div>
        <!-- End of Page Content-->
    </div>
@endsection
