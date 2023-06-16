@component('mail::button', [
    'url' => route('verification.verify', ['id' => $user->id, 'hash' => $user->email_verification_token]),
])
    Verifikasi Email
@endcomponent
