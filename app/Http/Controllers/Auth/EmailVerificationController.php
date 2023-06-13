<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    // public function notice(Request $request)
    // {
    //     return $request->user()->hasVerifiedEmail()
    //         ? redirect()->route('home') // Ubah rute ini sesuai dengan rute halaman utama Anda
    //         : view('auth.verify-email');
    // }
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * Memproses permintaan verifikasi email.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->verification_code === $request->code) {
            if ($request->fulfill()) {
                return redirect()->route('profil.index')->with('success', 'Email Anda telah terverifikasi.');
            }
        }

        return redirect()->route('verification.notice')->with('error', 'Kode verifikasi tidak valid atau sudah kedaluwarsa.');
    }

    /**
     * Mengirim ulang email verifikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home'); // Ganti dengan rute halaman utama Anda
        }

        $verificationCode = Str::random(6); // Menghasilkan kode verifikasi acak dengan 6 karakter

        $user->verification_code = $verificationCode;
        $user->save();

        // Kirim email verifikasi dengan kode
        Mail::to($user->email)->send(new VerificationCode($verificationCode));


        return back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }

    public function show()
    {
        return view('auth.verify-email');
    }

    public function sendVerificationCodeEmail()
    {
        $verificationCode = mt_rand(100000, 999999);

        // Simpan verification code ke dalam database (jika diperlukan)

        $user = Auth::user(); // Ganti dengan logika untuk mendapatkan user yang sedang login

        Mail::to($user->email)->send(new VerificationCode($verificationCode));


        // Tampilkan pesan sukses atau redirect ke halaman lain
        // ...
    }
}
