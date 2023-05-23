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
		} else {
			return back()->with('error', 'Login gagal');
		}
	}

	public function register()
	{
		$kerja = Pekerjaan::all();
		return view('auth.register')->with(compact('kerja'));
	}
}
