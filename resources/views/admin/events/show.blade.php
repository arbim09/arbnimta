@extends('layout.backend.app', [
    'title' => 'Detail Event',
    'pageTitle' => 'Detail Event',
])
@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

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
                <tr>
                    <th style="width: 20%;">QR Code</th>
                    <td style="width: 80%;"><img src="{{ $qrCodeDataUri }}" alt="QR Code"></td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Data Yang Mengikuti Event:</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="#">
                    <i class="fas fa-plus mr-1"></i> Testing
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
@endsection

@push('js')
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('dataAbsensi.event', $eventsId) }}",
                    "type": "GET" //(untuk mendapatkan data)
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                    },
                    {
                        data: 'pendidikan',
                        name: 'pendidikan',
                    },
                    {
                        data: 'pekerjaan',
                        name: 'pekerjaan',
                    },
                ]
            });
        });
    </script>
@endpush
