@extends('layout.backend.app', [
    'title' => 'Detail Admin',
    'pageTitle' => 'Detail Admin',
])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="btn-group">
                <a href="{{ route('admin.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                    title="Kembali ke Daftar Admin">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip"
                    title="Edit Data Admin">
                    <i class="far fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>{{ $user->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $user->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>{{ $user->tempat_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Agama</th>
                    <td>{{ $user->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pendidikan</th>
                    <td>{{ $user->pendidikan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pekerjaan</th>
                    <td>{{ $user->pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <th>Umur</th>
                    <td>{{ $user->umur }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $user->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Point</th>
                    <td>{{ $user->point ?? '-' }}</td>
                </tr>
                {{-- <tr>
                    <th>Badge</th>
                    <td>{{ $user->badge ?? '-' }}</td>
                </tr> --}}
                <tr>
                    <th>Password</th>
                    <td>{!! \Hash::check(env('PRIVATE_PASSWORD'), $user->password)
                        ? '<span class="badge badge-secondary">Default Password</span>'
                        : '-' !!}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
