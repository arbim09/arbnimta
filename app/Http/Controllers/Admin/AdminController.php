<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Posts;
use App\Models\Events;
use App\Models\Contact;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        $pesanTerbaca       = Contact::where('is_read', true)->count();
        $pesanBelumTerbaca  = Contact::where('is_read', false)->count();
        $berita             = Posts::count();
        $anggota            = User::count();
        $eventsAktif        = Events::where('status', true)->count();
        $eventsTidakAktif   = Events::where('status', false)->count();
        $jenisKelamin       = User::select('jenis_kelamin', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jenis_kelamin')
            ->get();
        $agama              = User::select('agama', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('agama')
            ->get();
        $pendidikan         = User::select('pendidikan', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('pendidikan')
            ->get();
        $pekerjaan          = User::with('pekerjaan')
            ->select('pekerjaan_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('pekerjaan_id')
            ->get();
        $umur               = User::select(
            DB::raw("CASE
                                        WHEN umur >= 0 AND umur <= 17 THEN 'Anak-Anak (0-17 Tahun)'
                                        WHEN umur >= 18 AND umur <= 25 THEN 'Remaja (18-25 Tahun)'
                                        WHEN umur >= 26 AND umur <= 55 THEN 'Dewasa (26-55 Tahun)'
                                        WHEN umur >= 56 AND umur <= 80 THEN 'Lanjut Usia (56-80 Tahun)'
                                        WHEN umur >= 81 AND umur <= 120 THEN 'Sepuh (81-120 Tahun)'
                                        ELSE 'Tidak Diketahui'
                                    END AS label"),
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy('label')
            ->get();
        return view('admin.dashboard', compact(
            'pesanTerbaca',
            'pesanBelumTerbaca',
            'umur',
            'berita',
            'anggota',
            'eventsAktif',
            'jenisKelamin',
            'eventsTidakAktif',
            'pendidikan',
            'pekerjaan',
            'agama'
        ));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row">';
                    $btn .= '<a href="' . route('admin.show', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                    $btn .= '<a href="' . route('admin.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
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
            'name'                  => 'required|string|max:255',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'alamat'                => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        // Buat Anggota baru dengan data yang diterima dari request
        $user = new User;

        if ($request->hasFile('foto_profil')) {
            $file               = $request->file('foto_profil');
            $filename           = $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore    = $filenameWithoutExt . '_' . time() . '.' . $extension;

            if (!$file->move(public_path('/images/profil/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $user->foto_profil = $filenameToStore;
        } else {
            $user->foto_profil = '/images/profil/user.png';
        }
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->jenis_kelamin    = $request->jenis_kelamin;
        $user->tempat_lahir     = $request->tempat_lahir;
        $user->tanggal_lahir    = $request->tanggal_lahir;
        $user->umur             = $request->umur;
        $user->pendidikan       = $request->pendidikan;
        $user->pekerjaan_id     = $request->pekerjaan_id;
        $user->alamat           = $request->alamat;
        $user->role             = $request->role;
        $user->no_hp            = $request->no_hp;
        $user->password         = Hash::make($request->password);
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
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->jenis_kelamin    = $request->jenis_kelamin;
        $user->tempat_lahir     = $request->tempat_lahir;
        $user->tanggal_lahir    = $request->tanggal_lahir;
        $user->umur             = $request->umur;
        $user->pendidikan       = $request->pendidikan;
        $user->pekerjaan_id     = $request->pekerjaan_id;
        $user->alamat           = $request->alamat;
        $user->agama            = $request->agama;
        $user->role             = $request->role;
        $user->no_hp            = $request->no_hp;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Data admin berhasil diupdate!'
            ]);
        }
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
