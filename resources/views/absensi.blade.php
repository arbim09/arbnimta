@extends('layout.anggotaLayouts.main')
@section('title')
    <title>Absensi</title>
@endsection
@push('css')
    <style>
        #reader {
            width: 300px;
            height: 300px;
            margin: 0 auto;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')
    <div>
        <form action="{{ route('store.absensi') }}" method="POST" id="absensiForm">
            @csrf
            <input type="hidden" id="event_id" name="event_id" value="">
            <div id="reader" width="600px"></div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            // alert('QR code berhasil dipindai!');
            const form = document.getElementById("absensiForm");
            document.getElementById("event_id").value = decodedText

            const formData = new FormData(form);
            fetch("{{ route('store.absensi') }}", {
                    headers: {
                        Accept: "application/json, text-plain, */*",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    method: "post",
                    body: formData
                })
                .then(function(response) {
                    return response.json()
                })
                .then(function(response) {
                    if (response.success) {
                        swal("Sukses!", "Absen event berhasil dilakukan", "success");
                    } else {
                        swal("Oops...!", "Anda Belum Melakukan Pendaftaran Event! Daftar Terlebih Dahulu", "error");
                    }
                })
                .catch(function(error) {
                    swal("Oops...!", "Absen event gagal dilakukan, silakan coba lagi 1", "error");
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

    <script>
        let scanning = true; // Tambahkan variabel untuk mengontrol status pemindaian

        function onScanSuccess(decodedText, decodedResult) {
            if (scanning) { // Tambahkan pengecekan apakah masih dalam status pemindaian
                scanning = false; // Setel status pemindaian ke false

                // handle the scanned code as you like, for example:
                console.log(`Code matched = ${decodedText}`, decodedResult);
                // alert('QR code berhasil dipindai!');
                const form = document.getElementById("absensiForm");
                document.getElementById("event_id").value = decodedText;

                const formData = new FormData(form);
                fetch("{{ route('store.absensi') }}", {
                        headers: {
                            Accept: "application/json, text-plain, */*",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        method: "post",
                        body: formData
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(response) {
                        if (response.success) {
                            swal({
                                title: "Sukses!",
                                text: "Absen event berhasil dilakukan",
                                icon: "success",
                                button: "OK"
                            });
                        } else {
                            if (response.message === "Anda telah melakukan absensi pada event ini sebelumnya.") {
                                swal({
                                    title: "Oops...!",
                                    text: "Anda telah melakukan absensi pada event ini sebelumnya.",
                                    icon: "error",
                                    button: "OK"
                                });
                            } else {
                                swal({
                                    title: "Oops...!",
                                    text: "Anda Belum Melakukan Pendaftaran Event! Daftar Terlebih Dahulu",
                                    icon: "error",
                                    button: "OK"
                                });
                            }
                        }
                        // Menghentikan pemindaian setelah pemindaian pertama
                        html5QrcodeScanner.clear();
                    })
                    .catch(function(error) {
                        swal("Oops...!", "Absen event gagal dilakukan, silakan coba lagi", "error");
                        // Menghentikan pemindaian setelah pemindaian pertama
                        html5QrcodeScanner.clear();
                    });
            }
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
    </script>
@endpush
