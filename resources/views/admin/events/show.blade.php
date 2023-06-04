@extends('layout.backend.app', [
    'title' => 'Detail Event',
    'pageTitle' => 'Detail Event',
])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="btn-group">
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                    title="Kembali ke Daftar Event">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('events.edit', $events->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip"
                    title="Edit Data Event">
                    <i class="far fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <th style="width: 20%;">Nama Event</th>
                    <td style="width: 80%;">{{ $events->name }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Kategori</th>
                    <td style="width: 80%;">{{ $events->category->name }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Keterangan</th>
                    <td style="width: 80%;">{!! html_entity_decode($events->keterangan) !!}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Foto</th>
                    <td style="width: 80%;"><img src="{{ asset('images/events/' . $events->image) }}"
                            alt="{{ $events->name }}" class="img-fluid" style="max-width: 200px; max-height: 200px;"></td>
                </tr>
                {{-- @if ($events->category->name == 'Pelatihan') --}}
                <tr>
                    <th style="width: 20%;">QR Code</th>
                    <td style="width: 80%;"><img src="{{ $qrCodeDataUri }}" alt="QR Code"></td>
                </tr>
                {{-- @elseif($events->category->name == 'Kegiatan')
            <tr>
                <th style="width: 20%;">QR Code</th>
                <td style="width: 80%;"><a href="{{route('form-absensi.kegiatan')}}"><img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(300)->generate('Ini adalah QR Code untuk kategori B')) !!}" alt="QR Code"></a></td>
            </tr>
            @else
            <tr>
                <th style="width: 20%;">QR Code</th>
                <td style="width: 80%;"><a href="https://example.com/daftar-hadir"><img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(300)->generate('$events->name')) !!}" alt="QR Code"></a></td>
            </tr>
             @endif --}}
            </table>
        </div>
    </div>
@endsection
