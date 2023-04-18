@extends('layout.backend.app',[
'title' => 'Detail Pesan',
'pageTitle' =>'Detail Pesan',
])

@section('content')

<div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('contact.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Kembali ke Daftar Pesan">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data Pesan">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th>Nama Pengirim</th>
                <td>{{ $contact->name }}</td>
            </tr>
            <tr>
                <th>E-mail Pengirim</th>
                <td>{{ $contact->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Subjek</th>
                <td>{{ $contact->subject ?? '-' }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $contact->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pesan</th>
                <td>{{ $contact->message ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! $contact->is_read ? '<span class="badge badge-success">Sudah Dibaca</span>' : '<span class="badge badge-danger">Belum Dibaca</span>' !!}</td>
            </tr>
        </table>
    </div>
</div>
@endsection