@extends('layout.backend.app', [
    'title' => 'Manage Absensi',
    'pageTitle' => 'Manage Absensi',
])

@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Absensi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nama Event</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('absensi.index') }}",
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
                        data: 'event_name',
                        name: 'event_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });
        });
    </script>

    <script>
        //form hapus
        function deleteData(id) {
            swal({
                title: "Anda yakin ingin menghapus data ini?",
                type: "warning",
                timer: 10000,
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus data!",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('absensi.destroy', ':id') }}".replace(':id', id),
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        swal("Berhasil!", "Data telah dihapus.", "success");
                        location.reload(); // Redirect ke halaman index setelah data berhasil dihapus
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        swal("Oops!", "Terjadi kesalahan saat menghapus data.", "error");
                    }
                });
            });
        }
    </script>
@endpush
