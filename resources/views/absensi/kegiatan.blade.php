<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Absesnsi</title>

    <!-- cssfiles -->
    <link rel="stylesheet" href="style.css">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('template/backend/sb-admin-2') }}/css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

<form action="{{route('absensi.kegiatan')}}" method="POST" id="kegiatan"> 
    @csrf  
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mt-5 mb-5 ml-5 mr-5">
                    <div class="container border">
                            <h5 class="mt-5 text-center">FORM ABSENSI KEGIATAN</h3>
                            <p class="text-center">RTIK CIREBON</p>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name"><b>Nama Lengkap</b></label>
                                    <input type="text" placeholder="Nama Lengkap" id="name" name="name" required>
                                </div>

                                <div class="col-lg-12">

                                    <label for="name"><b>E-mail</b></label>
                                    <input type="email" placeholder="E-Main" id="email" name="email" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="event_id"><b>Event</b></label>
                                    <select name="event_id" id="event_id" required>
                                        <option value="" selected disabled>Pilih Event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                     <button type="submit" class="bg-primary registerbtn mb-5 mt-4">Absen</button>
                </div>
            </div>  
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#kegiatan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('absensi.kegiatan') }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#kegiatan').serialize(),
                success: function(response) {
                    swal({
                        title: 'Anda Berhasil Absen!',
                        text: response.message,
                        icon: 'success',
                        button: 'Ok'
                    }).then(function() {
                        location.href = "{{ route('form-absensi.kegiatan') }}";
                    });
                },
                error: function(response) {
                    swal({
                        title: 'Gagal!',
                        text: response.responseJSON.message,
                        icon: 'error',
                        button: 'Ok'
                    });
                }
            });
        });
    });
</script>
</body>
</html>