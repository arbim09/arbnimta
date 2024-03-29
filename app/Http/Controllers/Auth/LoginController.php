<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
	public function authenticate()
	{
		$credentials = request()->only(['email', 'password']);
		if (Auth::attempt($credentials)) {
			$user = Auth::user();
			if ($user->role == 'admin') {
				return redirect()->intended('admin');
			} elseif ($user->role == 'pengurus') {
				return redirect()->intended('pengurus');
			} elseif ($user->role == 'anggota') {
				return redirect()->intended('/');
			}
		}
		// Jika autentikasi gagal, set pesan kesalahan ke session flash data
		return back()->withErrors(['error' => 'Email atau password yang Anda masukkan tidak valid.']);
	}

	public function register()
	{
		$kerja = Pekerjaan::all();
		return view('auth.register')->with(compact('kerja'));
	}
}
