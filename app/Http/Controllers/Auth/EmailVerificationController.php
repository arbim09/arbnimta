<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
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
        $user = Auth::user();
        return view('auth.verify-email', compact('user'));
    }

    /**
     * Memproses permintaan verifikasi email.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/'); // Ganti dengan rute halaman utama Anda
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('verification.notice')->with('success', 'Email Anda telah terverifikasi.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/'); // Ganti dengan rute halaman utama Anda
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }

    public function show()
    {
        $user = Auth::user();
        return view('auth.verify-email', compact('user'));
    }
}
