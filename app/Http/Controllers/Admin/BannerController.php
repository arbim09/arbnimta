<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banners::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($q) {
                    $nama = "<div class='text-left'><a class='btn btn-link btn-sm text-primary' title='Detail' href='/admin/banners/" . $q->id . "/'>$q->name</a></div>";;
                    return $nama;
                })
                ->addColumn('status', function ($q) {
                    if ($q->is_show == 1) {
                        $status = '<span class="badge badge-success">Aktif</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row">';
                    $btn .= '<a href="' . route('banners.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'nama', 'status'])
                ->make(true);
        }

        return view('admin.banners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData  = $request->validate([
            'name'      => 'required|max:255',
            'author'    => 'required',
            'is_show'   => 'required',
            'image'     => 'file|image|mimes:jpeg,png,jpg,gif|max:8048', // tambahan validasi pada input gambar
        ]);

        $banners        = new Banners;
        if ($request->hasFile('image')) {
            $file               = $request->file('image');
            $filename           = $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore    = $filenameWithoutExt . '_' . time() . '.' . $extension;

            if (!$file->move(public_path('/images/banners/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $banners->image = $filenameToStore;
        }
        $banners->name          = $validatedData['name'];
        $banners->is_show       = $validatedData['is_show'];
        $banners->author        = Auth::user()->name;
        $banners->save();
        return redirect()->route('banners.index')->with('success', 'Banner berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banners = Banners::findOrFail($id);
        return view('admin.banners.show')->with(compact('banners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banners = Banners::findOrFail($id);
        return view('admin.banners.edit')->with(compact('banners'));
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
        $validatedData  = $request->validate([
            'name'      => 'required|max:255',
            'author'    => 'required',
            'is_show'   => 'required',
            'image'     => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $banners                = Banners::findOrFail($id);
        if ($request->hasFile('image')) {
            $file               = $request->file('image');
            $filename           = $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore    = $filenameWithoutExt . '_' . time() . '.' . $extension;

            if (!$file->move(public_path('/images/banners/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            if ($banners->image && file_exists(public_path('/images/banners/' . $banners->image))) {
                unlink(public_path('/images/banners/' . $banners->image));
            }
            $banners->image = $filenameToStore;
        }
        $banners->name      = $validatedData['name'];
        $banners->is_show   = $validatedData['is_show'];
        $banners->author    = Auth::user()->name;
        $banners->save();

        return redirect()->route('banners.index')->with('success', 'Banner berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banners = Banners::findOrFail($id);

        if (file_exists(public_path('/images/banners/' . $banners->image))) {
            unlink(public_path('/images/banners/' . $banners->image));
        }
        $banners->delete();
    }
}
