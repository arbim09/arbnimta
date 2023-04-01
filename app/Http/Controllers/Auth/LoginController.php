<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
	public function authenticate()
	{
		$credentials = request()->only(['email','password']);

		if (Auth::attempt($credentials)) {
			return redirect()->route('admin');
		}else{
			return back()->with('error','Login gagal');
		}
	}
}
