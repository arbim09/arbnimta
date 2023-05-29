@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Absensi</title>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')
    {{-- <div class="card">
        <div id="reader" data-user-id="{{ auth()->user()->id }}" data-name="{{ auth()->user()->name }}"
            data-email="{{ auth()->user()->email }}"></div>
    </div> --}}

    {{-- <div>
  <form action="{{ route('store.absensi') }}" method="POST" id="absensiForm">
    @csrf
    <video id="video" width="300" height="200" style="border: 1px solid #ccc;"></video>
    <button type="button" onclick="startQRScanner()">Mulai Pemindaian</button>
    <button type="submit" id="submitBtn" style="display: none;">Simpan</button>
  </form>
</div> --}}
@endsection

@push('js')
    {{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    {{-- <script>
        function startQRScanner() {
            const videoElement = document.getElementById('video');
            // Mengakses kamera pengguna
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    videoElement.srcObject = stream;
                    videoElement.play();

                    // Memindai QR code dari kamera
                    const qrScanner = new Instascan.Scanner({ video: videoElement });
                    qrScanner.addListener('scan', function (content) {
                        // Meng-handle data hasil pemindaian QR code
                        console.log(content);

                        // Mengirim data ke server menggunakan permintaan AJAX
                        sendScanData(content);
                    });

                    Instascan.Camera.getCameras()
                        .then(function (cameras) {
                            if (cameras.length > 0) {
                                // Mengaktifkan pemindaian QR code
                                qrScanner.start(cameras[0]);
                            } else {
                                console.error('Tidak ada kamera yang tersedia.');
                            }
                        })
                        .catch(function (error) {
                            console.error('Error: ', error);
                        });
                })
                .catch((error) => {
                    console.error('Error accessing video stream: ', error);
                });
        }

        function sendScanData(data) {
            // Mengirim data ke server menggunakan permintaan AJAX
            const formData = new FormData();
            formData.append('qrCodeData', data);

            fetch('{{ route('store.absensi') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Meng-handle respons dari server
                })
                .catch(error => {
                    console.error('Error sending scan data: ', error);
                });
        }
</script> --}}

    {{-- <script>
        function onScanSuccess(decodedText, decodedResult) {
            // alert(decodedText);
            $('#result').val(decodedText);
            let id = decodedText;
            html5QrcodeScanner.clear().then(_ => {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('store.absensi') }}",
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        user_id: {{ auth()->user()->id }},
                        name: '{{ auth()->user()->name }}',
                        email: '{{ auth()->user()->email }}',
                        event_id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            alert('Data berhasil disimpan.');
                        } else {
                            alert('Gagal menyimpan data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan data.');
                    }
                });
            }).catch(error => {
                alert('something wrong');
            });

        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script> --}}
    {{-- <script>
        function onScanSuccess(decodedText, decodedResult) {
          // handle the scanned code as you like, for example:
          console.log(`Code matched = ${decodedText}`, decodedResult);

          // Mengambil data pengguna dari atribut data pada elemen #
          let userId = $('#reader').data('user-id');
          let name = $('#reader').data('name');
          let email = $('#reader').data('email');

          // Mengirim data ke server menggunakan AJAX
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url: "{{ route('store.absensi') }}",
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                user_id: userId,
                name: name,
                email: email,
                event_id: decodedText
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    swal('Sukses', 'Data berhasil disimpan.', 'success').then(() => {
                        // Redirect or perform additional actions after successful scan
                        window.location.href = "{{ route('home') }}";
                    });
                } else {
                    swal('Gagal', 'Gagal menyimpan data.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                swal('Kesalahan', 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
          });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        
    </script> --}}
@endpush
