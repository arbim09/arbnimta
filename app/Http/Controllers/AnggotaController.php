<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\VerifyEmailWithCode;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'name'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'password'      => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);
        if ($request->password !== $request->password_confirmation) {
            Session::flash('password_tidaksama', true);
            return back()->with('error', 'Password tidak cocok. Silakan coba lagi.')->withInput();
        }
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            Session::flash('email_exists', true);
            return redirect()->route('register')->withInput();
        }
        $user = new User;

        if ($request->hasFile('foto_profil')) {
            $file               = $request->file('foto_profil');
            $filename           = $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore    = $filenameWithoutExt . '_' . date('Ymd') . '.' . $extension;
            $image              = Image::make($file);
            $image->fit(200, 200);
            $image->save(public_path('/images/profil/') . $filenameToStore);

            if ($user->foto_profil && $user->foto_profil !== 'user.png' && file_exists(public_path('/images/profil/' . $user->foto_profil))) {
                unlink(public_path('/images/profil/' . $user->foto_profil));
            }
            $user->foto_profil  = $filenameToStore;
        } else {
            $user->foto_profil  = 'user.png'; // Gambar default jika tidak ada file yang diunggah
        }


        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->jenis_kelamin    = $request->jenis_kelamin;
        $user->tempat_lahir     = $request->tempat_lahir;
        $user->tanggal_lahir    = $request->tanggal_lahir;
        $user->agama            = $request->agama;
        $user->tanggal_lahir    = $request->tanggal_lahir;
        $tanggalLahir           = Carbon::parse($request->tanggal_lahir);
        $umur                   = $tanggalLahir->age;
        $user->umur             = $umur;
        $user->pendidikan       = $request->pendidikan;
        $user->pekerjaan_id     = $request->pekerjaan_id;
        $user->alamat           = $request->alamat;
        $user->foto_profil      = 'user.png';
        $user->no_hp            = $request->no_hp;
        $user->password         = Hash::make($request->password);
        $user->save();

        return redirect()->route('register')->with('success', 'Selamat Anda Berhasil Mendaftar!');
    }
}
