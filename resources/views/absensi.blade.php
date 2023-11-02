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
            {{-- <input type="hidden" id="waktu_mulai" name="waktu_mulai">
            <input type="hidden" id="jam" name="jam"> --}}
            <div id="reader" width="600px"></div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        let scanning = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (scanning) {
                scanning = false;
                console.log(`Code matched = ${decodedText}`, decodedResult);
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
                        html5QrcodeScanner.clear();
                    })
                    .catch(function(error) {
                        swal("Oops...!", "Absen event gagal dilakukan, silakan coba lagi", "error");
                        html5QrcodeScanner.clear();
                    });
            }
        }

        function onScanFailure(error) {
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

    {{-- <script>
        let scanning = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (scanning) {
                scanning = false;
                console.log(`Code matched = ${decodedText}`, decodedResult);
                const qrCodeData = decodedText.split(';').reduce((acc, item) => {
                    const [key, value] = item.split(':');
                    acc[key] = value;
                    return acc;
                }, {});

                const eventId = qrCodeData.event_id;
                const startTime = qrCodeData.waktu_mulai;
                const jam = qrCodeData.jam;

                const eventStartTime = new Date(`${startTime} ${jam}`).getTime();
                const eventExpiryTime = new Date(qrCodeData.expiry).getTime();

                const now = new Date().getTime();

                if (now >= eventStartTime && now <= eventExpiryTime) {
                    const form = document.getElementById("absensiForm");
                    document.getElementById("event_id").value = eventId;

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
                                }
                            }
                            html5QrcodeScanner.clear();
                        })
                        .catch(function(error) {
                            swal("Oops...!", "Absen event gagal dilakukan, silakan coba lagi", "error");
                            html5QrcodeScanner.clear();
                        });
                } else {
                    swal({
                        title: "Oops...!",
                        text: "QR code telah kadaluarsa.",
                        icon: "error",
                        button: "OK"
                    });
                    html5QrcodeScanner.clear();
                }
            }
        }

        function onScanFailure(error) {
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

    {{-- <script>
        let scanning = true;


        function onScanSuccess(decodedText, decodedResult) {
            if (scanning) {
                scanning = false;
                console.log(`Code matched = ${decodedText}`, decodedResult);
                const qrCodeData = decodedText.split(';').reduce((acc, item) => {
                    const [key, value] = item.split(':');
                    acc[key] = value;
                    return acc;
                }, {});

                const eventId = qrCodeData.event_id;
                const startTimeString = qrCodeData.waktu_mulai.replace(' ', 'T'); // Ubah format spasi menjadi "T"
                const expiryTimeString = qrCodeData.expiry.replace(' ', 'T');

                const eventStartTime = new Date(startTimeString).getTime();
                const eventExpiryTime = new Date(expiryTimeString).getTime();
                const now = new Date().getTime();

                if (now >= eventStartTime && now <= eventExpiryTime) {
                    const form = new FormData();
                    form.append('event_id', eventId); // Tambahkan event_id ke FormData

                    fetch("{{ route('store.absensi') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    "content"),
                            },
                            body: form,
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
                                }
                            }
                            html5QrcodeScanner.clear();
                        })
                        .catch(function(error) {
                            swal("Oops...!", "Absen event gagal dilakukan, silakan coba lagi", "error");
                            html5QrcodeScanner.clear();
                        });
                } else {
                    const expiryTime = new Date(qrCodeData.expiry).toLocaleString();
                    swal({
                        title: "Oops...!",
                        text: `QR code telah kadaluarsa pada ${expiryTime}`,
                        icon: "error",
                        button: "OK"
                    });
                    html5QrcodeScanner.clear();
                }
            }
        }

        function onScanFailure(error) {
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
