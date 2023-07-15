@extends('layout.backend.app', [
    'title' => 'Manage Data Pendaftaran Events',
    'pageTitle' => 'Manage Data Pendaftaran Events',
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
            <h5 class="card-title">Data Pendaftaran Events</h5>
            <div class="card-tools ml-auto mr-0">
                <a href="{{ route('pengurus.dataPendaftaranExport', ['event_id' => ':event_id']) }}" id="export-link"
                    class="btn btn-primary btn-sm" data-toggle="tooltip" title="Eksport">
                    <i class="fas fa-download mr-1"></i> Eksport
                </a>
            </div>

        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="event-acara">Pilih Event: </label>
                <select id="event-acara" class="form-control select2" name="event_id" data-event-id="">
                    <option value="">Semua</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nama Event</th>
                            <th>No HP</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengurus.pendaftaran.event') }}",
                    type: "GET",
                    data: function(data) {
                        data.event_id = $('#event-acara').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                        data: 'events_name',
                        name: 'events_name'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }
                ]
            });

            $('#event-acara').on('change', function() {
                table.ajax.reload(); // Memuat ulang data menggunakan permintaan AJAX yang diperbarui
            });
        });
    </script>

    <script>
        // Form hapus
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
                    url: "{{ route('daftar.destroy', ':id') }}".replace(':id', id),
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        swal("Berhasil!", "Data telah dihapus.", "success");
                        location.reload(); // Redirect ke halaman index setelah data berhasil dihapus
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        swal("Oops!", "Terjadi kesalahan saat menghapus data: " + error, "error");
                    }
                }).fail(function(xhr, status, error) {
                    console.log(xhr.responseText);
                    swal("Oops!", "Terjadi kesalahan saat menghapus data: " + error, "error");
                });
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#event-acara').on('change', function() {
                var eventId = $(this).val();
                var exportUrl =
                    "{{ route('pengurus.dataPendaftaranExport', ['event_id' => ':event_id']) }}";
                exportUrl = exportUrl.replace(':event_id', eventId);
                $('#export-link').attr('href', exportUrl);
            });
        });
    </script>
@endpush
