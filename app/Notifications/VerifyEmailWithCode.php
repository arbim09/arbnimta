<?php

namespace App\Notifications;

use App\Mail\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailWithCode extends VerifyEmail implements ShouldQueue
{
    use Queueable;
    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrlWithCode($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Jika Anda tidak membuat permintaan ini, Anda dapat mengabaikannya.');
    }

    protected function verificationUrlWithCode($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification() . $notifiable->verification_code),
            ]
        );

        return $url;
    }
}
