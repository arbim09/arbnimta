@extends('layout.backend.app',[
    'title' => 'Detail Banner',
    'pageTitle' =>'Detail Banner',
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('banners.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Kembali ke Daftar Berita">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('banners.edit', $banners->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data Berita">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th style="width: 20%;">Nama Banner</th>
                <td style="width: 80%;">{{ $banners->name }}</td>
            </tr>
            <tr>
                <th>Pembuat Banner</th>
                <td>{{ $banners->author }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Dibuat Pada</th>
                <td style="width: 80%;">{{ $banners->created_at->format('d M Y') }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Status</th>
                <td style="width: 80%;">{{ $banners->is_show == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Foto</th>
                <td style="width: 80%;"><img src="{{ asset('images/banners/'.$banners->image) }}" alt="{{ $banners->name }}" class="img-fluid" width="350"></td>
            </tr>
        </table>
    </div>
</div>
@endsection