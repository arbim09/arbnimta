<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view ('admin.dashboard');
    }

    public function index(Request $request)
    {          
        if ($request->ajax()) {
            $data = User::select('*')->orderBy('created_at','DESC');
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
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
    $request->validate([
        'name'          => 'required|string|max:255',
        'password'      => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
    ]);

    // Buat Anggota baru dengan data yang diterima dari request
    $admin = new User;
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->password = Hash::make($request->password);
    $admin->save();

    // Redirect ke halaman utama dengan pesan sukses

    return redirect()->route('admin.index')->with('Success', 'Data Berhasil Disimpan!');
    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.admin.show')->with(compact('admin'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.admin.edit')->with(compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $rules = [
            'name'          => 'required|string|max:255',
        ];
    
        $validatedData = $request->validate($rules);
    
        $admin->name = $validatedData['name'];
        $admin->email = $request->email;
    
        // Check if password field is present in request
        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }
    
        $admin->save();
    
        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Data admin berhasil diupdate!'
        ]);
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
