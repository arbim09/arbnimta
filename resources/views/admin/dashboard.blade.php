@extends('layout.backend.app', [
    'title' => 'Dashboard',
    'pageTitle' => 'Dashboard',
])
@section('content')
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Anggota: </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $anggota }}</div>
                            <a href="{{ route('admin.index') }}" style="mb-0">Lihat selengkapnya</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Berita: </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $berita }}</div>
                            <a href="{{ route('posts.index') }}" style="mb-0">Lihat selengkapnya</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Events:
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">Aktif: {{ $eventsAktif }}
                                    </div>
                                    <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">Tidak Aktif:
                                        {{ $eventsTidakAktif }}</div>
                                    <a href="{{ route('events.index') }}" style="mb-0">Lihat selengkapnya</a>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pesan:</div>
                            <div class="h7 mb-0 font-weight-bold text-gray-800">Sudah dibaca: {{ $pesanTerbaca }}</div>
                            <div class="h7 mb-0 font-weight-bold text-gray-800">Belum sudah dibaca: {{ $pesanBelumTerbaca }}
                            </div>
                            <a href="{{ route('contact.index') }}" style="mb-0">Lihat selengkapnya</a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <div class="d-flex">
                <div class="mr-2">Pilih Jenis Sortir:</div>
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
                    <h6 class="m-0 font-weight-bold text-primary" id="chartTitle">Users</h6>
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
                    <h6 class="m-0 font-weight-bold text-primary" id="chartTitle">Users</h6>
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
@stop
@push('js')
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
@endpush
