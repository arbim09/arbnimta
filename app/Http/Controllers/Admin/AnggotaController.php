<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Anggota::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('anggota.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('anggota.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.anggota.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.anggota.create');
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
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tempat_lahir'  => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'alamat'        => 'required|string',
        'password'      => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
    ]);

    // Buat Anggota baru dengan data yang diterima dari request
    $anggota = new Anggota;
    $anggota->name = $request->name;
    $anggota->email = $request->email;
    $anggota->jenis_kelamin = $request->jenis_kelamin;
    $anggota->tempat_lahir = $request->tempat_lahir;
    $anggota->tanggal_lahir = $request->tanggal_lahir;
    $anggota->umur = $request->umur;
    $anggota->alamat = $request->alamat;
    $anggota->no_hp = $request->no_hp;
    $anggota->password = Hash::make($request->password);
    $anggota->save();

    // Redirect ke halaman utama dengan pesan sukses

    return redirect()->route('anggota.index')->with('Success', 'Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.show')->with(compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.edit')->with(compact('anggota'));
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
        $anggota = Anggota::findOrFail($id);

        $rules = [
            'name'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
        ];
    
        $validatedData = $request->validate($rules);
    
        $anggota->name = $validatedData['name'];
        $anggota->jenis_kelamin = $validatedData['jenis_kelamin'];
        $anggota->tempat_lahir = $validatedData['tempat_lahir'];
        $anggota->tanggal_lahir = $validatedData['tanggal_lahir'];
        $anggota->alamat = $validatedData['alamat'];
        $anggota->no_hp = $request->no_hp;
        $anggota->email = $request->email;
    
        // Check if password field is present in request
        if (!empty($request->password)) {
            $anggota->password = Hash::make($request->password);
        }
    
        $anggota->save();
    
        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Data anggota berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }
        $anggota->delete();
        return response()->json(['message' => 'Anggota berhasil dihapus'], 200);
    }

    public function chart()
    {
        $data = Anggota::select('gender', DB::raw('count(*) as total'))
                        ->groupBy('gender')
                        ->get();
        
        return response()->json($data);
    }
}
