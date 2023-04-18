<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form</title>
</head>
<body>
    <h2>Pesan baru dari formulir kontak:</h2>
    <hr>
    <p>Nama: {{ $data['name'] }}</p>
    <p>Alamat email: {{ $data['email'] }}</p>
    <p>Subjek: {{ $data['subject'] }}</p>
    <p>No HP: {{ $data['no_hp'] }}</p>
    <p>Pesan:</p>
    <p>{{ $data['message'] }}</p>
</body>
</html>