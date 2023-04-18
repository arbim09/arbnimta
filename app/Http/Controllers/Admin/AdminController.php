<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Pekerjaan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Gate::allows('admin')|| Gate::allows('pengurus')) {
                return $next($request);
            }

            abort(403, "Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.");
        });
    }

    public function dashboard()
    {
        return view ('admin.dashboard');
    }

    public function index(Request $request)
    {          
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('admin.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('admin.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.admin.index');
    }

    public function create()
    {
        $kerja = Pekerjaan::all();
        return view('admin.admin.create')->with(compact('kerja'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'name'          => 'required|string|max:255',   
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'password'      => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',     
        ]);

        // Buat Anggota baru dengan data yang diterima dari request
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->umur = $request->umur;
        $user->pendidikan = $request->pendidikan;
        $user->pekerjaan_id = $request->pekerjaan_id;
        $user->alamat = $request->alamat;
        $user->role = $request->role;
        $user->no_hp = $request->no_hp;
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect ke halaman utama dengan pesan sukses

        return redirect()->route('admin.index')->with('Success', 'Data Berhasil Disimpan!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.admin.show')->with(compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $kerja = Pekerjaan::all();
        return view('admin.admin.edit')->with(compact('user', 'kerja'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => "required|string|email|max:255|unique:users,email,{$id}",
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'password'      => 'nullable|string|min:8|confirmed',
        ]);
    
        // Ambil data user dari database
        $user = User::findOrFail($id);
        
        // Update data user dengan data baru dari request
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->umur = $request->umur;
        $user->pendidikan = $request->pendidikan;
        $user->pekerjaan_id = $request->pekerjaan_id;
        $user->alamat = $request->alamat;
        $user->role = $request->role;
        $user->no_hp = $request->no_hp;
    
        // Update password jika password diisi pada form
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        // Kembalikan respons sukses jika request di-handle oleh ajax
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Data admin berhasil diupdate!'
            ]);
        }
    
        // Redirect ke halaman daftar user jika request tidak di-handle oleh ajax
        return redirect()->route('admin.index')->with('success', 'Data admin berhasil diupdate!');
    }
    public function destroy($id)
    {
        $admin = User::find($id);

        if (!$admin) {
            return response()->json(['message' => 'admin tidak ditemukan'], 404);
        }
        $admin->delete();
        return response()->json(['message' => 'admin berhasil dihapus'], 200);
    }
}
