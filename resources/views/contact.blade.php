<form method="POST" action="{{ route('send.email') }}">
    @csrf
    <div class="form-group">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda">
    </div>

    <div class="form-group">
        <label for="email">Alamat Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email Anda">
    </div>

    <div class="form-group">
        <label for="subject">Subjek</label>
        <input type="text" name="subject" class="form-control" placeholder="Masukkan subjek pesan">
    </div>

    <div class="form-group">
        <label for="no_hp">No Hp</label>
        <input name="no_hp" class="form-control" placeholder="Masukkan No HP Anda">
    </div>

    <div class="form-group">
        <label for="message">Pesan</label>
        <textarea name="message" class="form-control" placeholder="Masukkan pesan Anda"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Kirim</button>
</form>