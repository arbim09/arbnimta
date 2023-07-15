@extends('layout.backend.app', [
    'title' => 'Manage Events',
    'pageTitle' => 'Manage Events',
])

@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Daftar Events</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Tambah Data">
                    <i class="fas fa-plus mr-1"></i> Tambah Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="category">Pilih Kategori Event: </label>
                <select id="category" class="form-control select2" name="category_id" data-event-id="">
                    <option value="">Semua</option>
                    @foreach ($category as $cate)
                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Kategori</th>
                            <th>Status Event</th>
                            <th>Tampilkan di halaman</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('events.index') }}",
                    "type": "GET",
                    data: function(data) {
                        // Mendapatkan nilai kategori yang dipilih
                        var selectedCategoryId = $('#category').val();
                        // Menambahkan parameter category_id ke data yang dikirim ke server
                        data.category_id = selectedCategoryId;
                    }
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
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'halaman',
                        name: 'halaman'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });

            $('#category').on('change', function() {
                // Memuat ulang tabel saat kategori dipilih berubah
                table.ajax.reload();
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
                    url: "{{ route('events.destroy', ':id') }}".replace(':id', id),
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
