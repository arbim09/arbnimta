@extends('layout.backend.app',[
    'title' => 'Detail Admin',
    'pageTitle' =>'Detail Admin',
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('admin.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Kembali ke Daftar Admin">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data Admin">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $admin->name }}</td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td>{{ $admin->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>{!! \Hash::check(env('PRIVATE_PASSWORD'), $admin->password) ? '<span class="badge badge-secondary">Default Password</span>' : '-' !!}</td>
            </tr>
        </table>
    </div>
</div>
@endsection