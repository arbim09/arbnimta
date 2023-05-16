<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
