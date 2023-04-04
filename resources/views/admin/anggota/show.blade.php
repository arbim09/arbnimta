@extends('layout.backend.app',[
    'title' => 'Detail Anggota',
    'pageTitle' =>'Detail Anggota',
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Kembali ke Daftar Admin">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data Admin">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $anggota->name }}</td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td>{{ $anggota->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>No Telepon</th>
                <td>{{ $anggota->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $anggota->tempat_lahir ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $anggota->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>{!! \Hash::check(env('PRIVATE_PASSWORD'), $anggota->password) ? '<span class="badge badge-secondary">Default Password</span>' : '-' !!}</td>
            </tr>
        </table>
    </div>
</div>
@endsection