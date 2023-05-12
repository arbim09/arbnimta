<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Access\Gate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Events::select('*')->orderBy('created_at', 'desc');;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                        return $row->category ? $row->category->name : '-';
                    })
                    ->addColumn('status', function($q){
                        if ($q->is_show == 1) {
                            $status = '<span class="badge badge-success">Aktif</span>';
                        } else {
                            $status = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('events.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('events.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'category_name', 'status'])
                    ->make(true);
        }
        
        return view('admin.events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_id = Category::all();
        return view('admin.events.create')->with(compact('category_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diinputkan oleh user
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'keterangan' => 'nullable',
            'is_show' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Membuat event baru dengan data yang diinputkan oleh user
        $event = new Events;
        $event->name = $validatedData['name'];
        $event->is_show = $validatedData['is_show'];
        $event->category_id = $validatedData['category_id'];
        $event->keterangan = $validatedData['keterangan'];
    
        // Menyimpan gambar event (jika ada)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt.'_'.time().'.'.$extension;
    
            if (!$file->move(public_path('/images/events/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $event->image = $filenameToStore;
        }
        // Menyimpan event ke dalam database
        $event->save();
    
        // Kembali ke halaman utama dengan pesan sukses
        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = Events::findOrFail($id);
        return view('admin.events.show')->with(compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Events::findOrFail($id);
        $categories = Category::all();
        return view('admin.events.edit')->with(compact('categories', 'event'));
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
        // Validasi data yang diinputkan oleh user
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'keterangan' => 'nullable',
            'is_show' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Mengambil event yang akan diupdate
            $event = Events::find($id);
            if (!$event) {
                return response()->json(['error' => 'Event tidak ditemukan.'], 404);
            }

            // Update data event dengan data yang diinputkan oleh user
            $event->name = $validatedData['name'];
            $event->is_show = $validatedData['is_show'];
            $event->category_id = $validatedData['category_id'];
            $event->keterangan = $validatedData['keterangan'];

            // Menghapus gambar lama jika ada gambar baru yang diunggah
            if ($request->hasFile('image')) {
                $oldImage = $event->image;
                if ($oldImage) {
                    if (file_exists(public_path('/images/events/'.$oldImage))) {
                        unlink(public_path('/images/events/'.$oldImage));
                    }
                }
            }

            // Menyimpan gambar event yang baru (jika ada)
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                $filenameToStore = $filenameWithoutExt.'_'.time().'.'.$extension;

                if (!$file->move(public_path('/images/events/'), $filenameToStore)) {
                    return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
                }
                $event->image = $filenameToStore;
            }

            // Menyimpan event ke dalam database
            $event->save();

            // Kembali ke halaman utama dengan pesan sukses
            return redirect()->route('events.index')->with('success', 'Event berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $events = Events::find($id);

        if (!$events) {
            return response()->json(['message' => 'events tidak ditemukan'], 404);
        }
        $events->delete();
        return response()->json(['message' => 'events berhasil dihapus'], 200);
    }

    public function kegiatan(Request $request)
    {
        if ($request->ajax()) {
            $data = Events::select('*')
            ->where('category_id', '=', '3')
            ->orderBy('created_at', 'desc')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                        return $row->category ? $row->category->name : '-';
                    })
                    ->addColumn('status', function($q){
                        if ($q->is_show == 1) {
                            $status = '<span class="badge badge-success">Aktif</span>';
                        } else {
                            $status = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('events.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('events.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'category_name',  'status'])
                    ->make(true);
        }
        
        return view('admin.events.kegiatan');
    }

    public function acara(Request $request)
    {
        if ($request->ajax()) {
            $data = Events::select('*') 
            ->where('category_id', '=', '2')
            ->orderBy('created_at', 'desc')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                        return $row->category ? $row->category->name : '-';
                    })
                    ->addColumn('status', function($q){
                        if ($q->is_show == 1) {
                            $status = '<span class="badge badge-success">Aktif</span>';
                        } else {
                            $status = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('events.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('events.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'category_name', 'status'])
                    ->make(true);
        }
        
        return view('admin.events.acara');
    }

    public function pelatihan(Request $request)
    {
        if ($request->ajax()) {
            $data = Events::select('*')
            ->where('category_id', '=', '1')
            ->orderBy('created_at', 'desc')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                        return $row->category ? $row->category->name : '-';
                    })
                    ->addColumn('status', function($q){
                        if ($q->is_show == 1) {
                            $status = '<span class="badge badge-success">Aktif</span>';
                        } else {
                            $status = '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        return $status;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<a href="'.route('events.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('events.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'category_name', 'status'])
                    ->make(true);
        }
        
        return view('admin.events.pelatihan');
    }
}
