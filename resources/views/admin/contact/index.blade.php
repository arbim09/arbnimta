@extends('layout.backend.app', [
    'title' => 'Manage Pesan Masuk',
    'pageTitle' => 'Manage Pesan Masuk',
])

@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a href="#" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah Data">
          <i class="fas fa-plus mr-1"></i> Ini buat print
        </a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart" id="chart">

                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@push('js')
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/chart-pie-demo.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/chart-bar-demo.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('contact.index') }}",
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
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'status',
                        name: 'status'
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



        //form hapus
    </script>

    <script>
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
                    url: "{{ route('contact.destroy', ':id') }}".replace(':id', id),
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

    <script>
        Highcharts.chart('container', {
            data: {
                table: 'datatable'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Live births in Norway'
            },
            subtitle: {
                text: 'Source: <a href="https://www.ssb.no/en/statbank/table/04231" target="_blank">SSB</a>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Amount'
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' ' + this.point.name.toLowerCase();
                }
            }
        });
    </script>
@endpush
