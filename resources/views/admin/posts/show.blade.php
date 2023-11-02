@extends('layout.backend.app', [
    'title' => 'Detail Berita',
    'pageTitle' => 'Detail Berita',
])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="btn-group">
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                    title="Kembali ke Daftar Berita">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('posts.edit', $posts->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip"
                    title="Edit Data Berita">
                    <i class="far fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <tr>
                    <th style="width: 20%;">Judul</th>
                    <td style="width: 80%;">{{ $posts->title }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td>{{ $posts->slug }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Kategori</th>
                    <td style="width: 80%;">{{ $posts->category->name }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Isi</th>
                    <td style="width: 80%;">{!! html_entity_decode($posts->content) !!}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Foto</th>
                    <td style="width: 80%;"><img src="{{ asset('images/posts/' . $posts->image) }}"
                            alt="{{ $posts->title }}" class="img-fluid" width="350"></td>
                </tr>
            </table>
        </div>
    </div>
@endsection
