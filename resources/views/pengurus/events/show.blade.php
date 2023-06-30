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
                <a href="{{ route('event.index') }}" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                    title="Kembali ke Daftar Event">
                    <i class="far fa-arrow-alt-circle-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('event.edit', $events->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip"
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
                    <th style="width: 20%;">Waktu Event</th>
                    <td style="width: 80%;">
                        {{ $events->waktu_mulai ? \Carbon\Carbon::parse($events->waktu_mulai)->format('d/m/Y') : '-' }} Jam:
                        {{ $events->jam }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Keterangan Daring/Luring</th>
                    <td style="width: 80%;">{{ $events->ondar }}</td>
                </tr>
                <tr>
                    <th style="width: 20%;">Status Event</th>
                    <td style="width: 80%;">{{ $events->status ? 'Berjalan' : 'Selesai' }}</td>
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
                <a href="{{ route('pengurus.dataAbsensiExport.event', $events->id) }}" class="btn btn-primary btn-sm"
                    data-toggle="tooltip" title="#">
                    <i class="fas fa-download  mr-1"></i> Export
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
    <div class="card collapsed-card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Pilih Jenis Sortir Data:</h5>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-flex">
                    {{-- <div class="mr-2">Pilih Jenis Sortir:</div> --}}
                    <a class="btn btn-link" href="#" onclick="getDataByJenisKelamin()">Jenis Kelamin</a>
                    <a class="btn btn-link" href="#" onclick="getDataByAgama()">Agama</a>
                    <a class="btn btn-link" href="#" onclick="getDataByPekerjaan()">Pekerjaan</a>
                    <a class="btn btn-link" href="#" onclick="getDataByPendidikan()">Pendidikan</a>
                    <a class="btn btn-link" href="#" onclick="getDataByUmur()">Umur</a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Bar Chart -->
            <div class="col-xl- col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="chartTitle">{{ $events->name }}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary" id="chartTitle">{{ $events->name }}</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($events->status == false)
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title">Upload Dokumentasi:</h5>
                <div class="card-tools ml-auto mr-0">
                    @if ($dokumentasi)
                        <a href="{{ route('dokumen.edit', $dokumentasi->id) }}" class="btn btn-primary btn-sm"
                            data-toggle="tooltip" title="#">
                            <i class="fas fa-edit  mr-1"></i> Edit
                        </a>
                    @else
                        <a href="{{ route('dokumen.create') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                            title="#">
                            <i class="fas fa-upload  mr-1"></i> Upload
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">Gambar 1</th>
                            <td style="width: 80%;">
                                @if ($dokumentasi && $dokumentasi->gambar1)
                                    <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar1) }}" alt="testing"
                                        class="img-fluid" style="max-width: 400px; max-height: 400px;">
                                @else
                                    Tidak ada gambar dokumentasi
                                @endif
                            </td>
                            <td>
                                @if ($dokumentasi && $dokumentasi->gambar1)
                                    <form action="{{ route('dokumentasi.pengurus.delete-gambar1', $dokumentasi->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button">Hapus2</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Gambar 2</th>
                            <td style="width: 80%;">
                                @if ($dokumentasi && $dokumentasi->gambar2)
                                    <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar2) }}" alt="testing"
                                        class="img-fluid" style="max-width: 400px; max-height: 400px;">
                                @else
                                    Tidak ada gambar dokumentasi
                                @endif
                            </td>
                            <td>
                                @if ($dokumentasi && $dokumentasi->gambar2)
                                    <form action="{{ route('dokumentasi.pengurus.delete-gambar2', $dokumentasi->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button">Hapus2</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Gambar 3</th>
                            <td style="width: 80%;">
                                @if ($dokumentasi && $dokumentasi->gambar3)
                                    <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar3) }}" alt="testing"
                                        class="img-fluid" style="max-width: 400px; max-height: 400px;">
                                @else
                                    Tidak ada gambar dokumentasi
                                @endif
                            </td>
                            <td>
                                @if ($dokumentasi && $dokumentasi->gambar3)
                                    <form action="{{ route('dokumentasi.pengurus.delete-gambar3', $dokumentasi->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button">Hapus3</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Gambar 4</th>
                            <td style="width: 80%;">
                                @if ($dokumentasi && $dokumentasi->gambar4)
                                    <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar4) }}" alt="testing"
                                        class="img-fluid" style="max-width: 400px; max-height: 400px;">
                                @else
                                    Tidak ada gambar dokumentasi
                                @endif
                            </td>
                            <td>
                                @if ($dokumentasi && $dokumentasi->gambar4)
                                    <form action="{{ route('dokumentasi.pengurus.delete-gambar4', $dokumentasi->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button">Hapus4</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 20%;">Gambar 5</th>
                            <td style="width: 80%;">
                                @if ($dokumentasi && $dokumentasi->gambar5)
                                    <img src="{{ asset('images/dokumentasi/' . $dokumentasi->gambar5) }}" alt="testing"
                                        class="img-fluid" style="max-width: 400px; max-height: 400px;">
                                @else
                                    Tidak ada gambar dokumentasi
                                @endif
                            </td>
                            <td>
                                @if ($dokumentasi && $dokumentasi->gambar5)
                                    <form action="{{ route('dokumentasi.pengurus.delete-gambar5', $dokumentasi->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button">Hapus5</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    @endif
@endsection

@push('js')
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function generateColors(numColors) {
            var colors = [];
            var opacity = 0.2; // Opacity value for background colors

            for (var i = 0; i < numColors; i++) {
                var hue = (i * (360 / numColors)).toFixed(0);
                var color = 'hsla(' + hue + ', 100%, 50%, ' + opacity + ')';
                colors.push(color);
            }

            return colors;
        }
    </script>
    <script>
        var barChart, pieChart;

        function getDataByJenisKelamin() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            destroyCharts();

            // Ambil data jenis kelamin dari server (misalnya dengan AJAX)
            // dan siapkan data baru untuk grafik bar dan pie

            // Data jenis kelamin untuk grafik bar
            var barData = {
                labels: {!! $jenisKelamin->pluck('jenis_kelamin') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $jenisKelamin->pluck('jumlah') !!},
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)', // Warna kuning
                        'rgba(54, 162, 235, 0.2)' // Warna biru
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)', // Warna kuning
                        'rgba(54, 162, 235, 1)' // Warna biru
                    ],
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik bar baru
            var barCtx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Data jenis kelamin untuk grafik pie
            var pieData = {
                labels: {!! $jenisKelamin->pluck('jenis_kelamin') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $jenisKelamin->pluck('jumlah') !!},
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)', // Warna kuning
                        'rgba(54, 162, 235, 0.2)' // Warna biru
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)', // Warna kuning
                        'rgba(54, 162, 235, 1)' // Warna biru
                    ],
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik pie baru
            var pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: pieData.labels,
                    datasets: [{
                        label: pieData.datasets[0].label,
                        data: pieData.datasets[0].data,
                        backgroundColor: pieData.datasets[0].backgroundColor,
                        borderColor: pieData.datasets[0].borderColor,
                        borderWidth: pieData.datasets[0].borderWidth
                    }]
                },
                options: {
                    responsive: true
                }
            });
        }


        function getDataByAgama() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            destroyCharts();

            // Ambil data agama dari server (misalnya dengan AJAX)
            // dan siapkan data baru untuk grafik bar dan pie

            // Data agama untuk grafik bar
            var barData = {
                labels: {!! $agama->pluck('agama') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $agama->pluck('jumlah') !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Warna merah (Islam)
                        'rgba(54, 162, 235, 0.2)', // Warna biru (Kristen)
                        'rgba(255, 206, 86, 0.2)', // Warna kuning (Katolik)
                        'rgba(75, 192, 192, 0.2)', // Warna hijau (Hindu)
                        'rgba(153, 102, 255, 0.2)', // Warna ungu (Budha)
                        'rgba(255, 159, 64, 0.2)', // Warna oranye (Khonghucu)
                        'rgba(128, 128, 128, 0.2)' // Warna abu-abu (Lainnya)
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Warna merah (Islam)
                        'rgba(54, 162, 235, 1)', // Warna biru (Kristen)
                        'rgba(255, 206, 86, 1)', // Warna kuning (Katolik)
                        'rgba(75, 192, 192, 1)', // Warna hijau (Hindu)
                        'rgba(153, 102, 255, 1)', // Warna ungu (Budha)
                        'rgba(255, 159, 64, 1)', // Warna oranye (Khonghucu)
                        'rgba(128, 128, 128, 1)' // Warna abu-abu (Lainnya)
                    ],
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik bar baru
            var barCtx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Data agama untuk grafik pie
            var pieData = {
                labels: {!! $agama->pluck('agama') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $agama->pluck('jumlah') !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Warna merah (Islam)
                        'rgba(54, 162, 235, 0.2)', // Warna biru (Kristen)
                        'rgba(255, 206, 86, 0.2)', // Warna kuning (Katolik)
                        'rgba(75, 192, 192, 0.2)', // Warna hijau (Hindu)
                        'rgba(153, 102, 255, 0.2)', // Warna ungu (Budha)
                        'rgba(255, 159, 64, 0.2)', // Warna oranye (Khonghucu)
                        'rgba(128, 128, 128, 0.2)' // Warna abu-abu (Lainnya)
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Warna merah (Islam)
                        'rgba(54, 162, 235, 1)', // Warna biru (Kristen)
                        'rgba(255, 206, 86, 1)', // Warna kuning (Katolik)
                        'rgba(75, 192, 192, 1)', // Warna hijau (Hindu)
                        'rgba(153, 102, 255, 1)', // Warna ungu (Budha)
                        'rgba(255, 159, 64, 1)', // Warna oranye (Khonghucu)
                        'rgba(128, 128, 128, 1)' // Warna abu-abu (Lainnya)
                    ],
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik pie baru
            var pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true
                }
            });
        }

        function getDataByPendidikan() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            destroyCharts();

            // Ambil data pendidikan dari server (misalnya dengan AJAX)
            // dan siapkan data baru untuk grafik bar dan pie

            // Data pendidikan untuk grafik bar
            var barData = {
                labels: {!! $pendidikan->pluck('pendidikan') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $pendidikan->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $pendidikan->count() !!}),
                    borderColor: generateColors({!! $pendidikan->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik bar baru
            var barCtx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Data pendidikan untuk grafik pie
            var pieData = {
                labels: {!! $pendidikan->pluck('pendidikan') !!},
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $pendidikan->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $pendidikan->count() !!}),
                    borderColor: generateColors({!! $pendidikan->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik pie baru
            var pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true
                }
            });
        }

        function getDataByPekerjaan() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            destroyCharts();

            // Ambil data pekerjaan dari server (misalnya dengan AJAX)
            // dan siapkan data baru untuk grafik bar dan pie

            // Ambil kolom 'nama' dari objek koleksi $pekerjaan
            var pekerjaanNames = {!! $pekerjaan->pluck('pekerjaan.nama') !!};
            // Data pekerjaan untuk grafik bar
            var barData = {
                labels: pekerjaanNames,
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $pekerjaan->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $pekerjaan->count() !!}),
                    borderColor: generateColors({!! $pekerjaan->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik bar baru
            var barCtx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Data pekerjaan untuk grafik pie
            var pieData = {
                labels: pekerjaanNames,
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $pekerjaan->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $pekerjaan->count() !!}),
                    borderColor: generateColors({!! $pekerjaan->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik pie baru
            var pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true
                }
            });
        }

        function getDataByUmur() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            destroyCharts();

            // Ambil data umur dari server (misalnya dengan AJAX)
            // dan siapkan data baru untuk grafik bar dan pie

            // Ambil kolom 'label' dari objek koleksi $umur
            var umurLabels = {!! $umur->pluck('label') !!};

            // Data umur untuk grafik bar
            var barData = {
                labels: umurLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $umur->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $umur->count() !!}),
                    borderColor: generateColors({!! $umur->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik bar baru
            var barCtx = document.getElementById('barChart').getContext('2d');
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Data umur untuk grafik pie
            var pieData = {
                labels: umurLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: {!! $umur->pluck('jumlah') !!},
                    backgroundColor: generateColors({!! $umur->count() !!}),
                    borderColor: generateColors({!! $umur->count() !!}).map(color => color.replace('0.2)',
                        '1)')),
                    borderWidth: 1
                }]
            };

            // Menginisialisasi grafik pie baru
            var pieCtx = document.getElementById('pieChart').getContext('2d');
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true
                }
            });
        }




        function destroyCharts() {
            // Hapus grafik yang ada sebelumnya (jika ada)
            if (barChart) {
                barChart.destroy();
                barChart = null;
            }
            if (pieChart) {
                pieChart.destroy();
                pieChart = null;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            getDataByAgama();
        });
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('pengurus.dataAbsensi.event', $eventsId) }}",
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
