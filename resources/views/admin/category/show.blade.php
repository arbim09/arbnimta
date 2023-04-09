@extends('layout.backend.app',[
    'title' => 'Detail Kategori',
    'pageTitle' =>'Detail Kategori',
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('category.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Kembali ke Daftar Kategori">
                <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
            </a>
            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Data Kategori">
                <i class="far fa-edit mr-1"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $category->name }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection