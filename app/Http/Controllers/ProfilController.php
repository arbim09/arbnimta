<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfilController extends Controller
{

    protected $user;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = Auth::user();
        $kerja = Pekerjaan::all();
        return view('profile', compact('user', 'kerja'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$id}",
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($id);


        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt . '_' . date('Ymd') . '.' . $extension;
            $image = Image::make($file);
            $image->fit(300, 300);
            $image->save(public_path('/images/profil/') . $filenameToStore);
            if ($user->foto_profil && $user->foto_profil !== 'user.png' && file_exists(public_path('/images/profil/' . $user->foto_profil))) {
                unlink(public_path('/images/profil/' . $user->foto_profil));
            }
            $user->foto_profil = $filenameToStore;
        } elseif (!$user->foto_profil || $user->foto_profil === 'user.png') {
            $user->foto_profil = null;
        }
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => Carbon::parse($request->tanggal_lahir)->age,
            'pendidikan' => $request->pendidikan,
            'pekerjaan_id' => $request->pekerjaan_id,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
        if ($user->role === 'admin') {
            $user->save();
        } elseif ($user->role === 'pengurus') {
            $user->save();
        } else {
            $user->fill([
                'role' => $request->role,
            ])->save();
        }
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
