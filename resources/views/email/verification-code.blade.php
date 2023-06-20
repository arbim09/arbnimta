@component('mail::message')
    # Verifikasi Email

    Terima kasih telah mendaftar di aplikasi kami. Untuk melengkapi proses registrasi, silakan verifikasi email Anda dengan
    mengklik tombol di bawah:

    @component('mail::button', [
        'url' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_token]),
    ])
        Verifikasi Email
    @endcomponent

    Jika Anda tidak mendaftar di aplikasi kami, Anda dapat mengabaikan email ini.

    Terima kasih,<br>
    Tim Kami
@endcomponent
