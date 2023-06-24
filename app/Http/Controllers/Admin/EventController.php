<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Events;
use App\Models\Absensi;
use App\Models\Category;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
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
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
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
                    $btn .= '<a href="' . route('events.show', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                    $btn .= '<a href="' . route('events.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
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
            'waktu_mulai' => 'required',
            'jam' => 'required',
            'pilih_keterangan' => 'required',
            'ondar' => 'required',
            'status' => 'required'
        ]);

        // Membuat event baru dengan data yang diinputkan oleh user
        $event = new Events;
        $event->name = $validatedData['name'];
        $event->is_show = $validatedData['is_show'];
        $event->category_id = $validatedData['category_id'];
        $event->keterangan = $validatedData['keterangan'];
        $event->waktu_mulai = $validatedData['waktu_mulai'];
        $event->jam = $validatedData['jam'];
        $event->pilih_keterangan = $validatedData['pilih_keterangan'];
        $event->ondar = $validatedData['ondar'];
        $event->status = $validatedData['status'];

        // Menyimpan gambar event (jika ada)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt . '_' . time() . '.' . $extension;

            if (!$file->move(public_path('/images/events/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $image = Image::make(public_path('/images/events/') . $filenameToStore);
            $image->save(public_path('/images/events/') . $filenameToStore);
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
    // public function show($id)
    // {
    //     $events = Events::findOrFail($id);
    //     return view('admin.events.show')->with(compact('events'));
    // }
    public function show($id)
    {
        // Mendapatkan objek event berdasarkan ID
        $events = Events::find($id);
        if (!$events) {
            abort(404);
        }
        $eventId = $id;
        $qrCode = QrCode::format('png')->size(300)->generate($eventId);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCode);

        $jenisKelamin = User::join('absensis', 'users.id', '=', 'absensis.user_id')
            ->where('absensis.event_id', $eventId)
            ->select('users.jenis_kelamin', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('users.jenis_kelamin')
            ->get();
        $agama = User::join('absensis', 'users.id', '=', 'absensis.user_id')
            ->where('absensis.event_id', $eventId)
            ->select('users.agama', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('users.agama')
            ->get();
        $pendidikan = User::join('absensis', 'users.id', '=', 'absensis.user_id')
            ->where('absensis.event_id', $eventId)
            ->select('users.pendidikan', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('users.pendidikan')
            ->get();
        $pekerjaan = User::join('absensis', 'users.id', '=', 'absensis.user_id')
            ->join('pekerjaan', 'users.pekerjaan_id', '=', 'pekerjaan.id')
            ->where('absensis.event_id', $eventId)
            ->select('users.pekerjaan_id', 'pekerjaan.nama', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('users.pekerjaan_id', 'pekerjaan.nama')
            ->get();

        $umur = User::join('absensis', 'users.id', '=', 'absensis.user_id')
            ->where('absensis.event_id', $eventId)
            ->select(
                DB::raw("CASE
                    WHEN users.umur >= 0 AND users.umur <= 17 THEN 'Anak-Anak (0-17 Tahun)'
                    WHEN users.umur >= 18 AND users.umur <= 25 THEN 'Remaja (18-25 Tahun)'
                    WHEN users.umur >= 26 AND users.umur <= 55 THEN 'Dewasa (26-55 Tahun)'
                    WHEN users.umur >= 56 AND users.umur <= 80 THEN 'Lanjut Usia (56-80 Tahun)'
                    WHEN users.umur >= 81 AND users.umur <= 120 THEN 'Sepuh (81-120 Tahun)'
                    ELSE 'Tidak Diketahui'
                END AS label"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('label')
            ->get();

        return view('admin.events.show', [
            'events' => $events,
            'qrCodeDataUri' => $qrCodeDataUri,
            'eventsId' => $id,
            'jenisKelamin' => $jenisKelamin,
            'umur'  => $umur,
            'pendidikan'  => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'agama'  => $agama
        ]);
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
            'waktu_mulai' => 'required',
            'jam' => 'required',
            'pilih_keterangan' => 'required',
            'ondar' => 'required',
            'status' => 'required'
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
        $event->waktu_mulai = $validatedData['waktu_mulai'];
        $event->jam = $validatedData['jam'];
        $event->pilih_keterangan = $validatedData['pilih_keterangan'];
        $event->ondar = $validatedData['ondar'];
        $event->status = $validatedData['status'];

        // Menghapus gambar lama jika ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            $oldImage = $event->image;
            if ($oldImage) {
                if (file_exists(public_path('/images/events/' . $oldImage))) {
                    unlink(public_path('/images/events/' . $oldImage));
                }
            }
        }

        // Menyimpan gambar event yang baru (jika ada)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt . '_' . time() . '.' . $extension;

            if (!$file->move(public_path('/images/events/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $image = Image::make(public_path('/images/events/') . $filenameToStore);
            // $image->fit(400, 400);
            $image->save(public_path('/images/events/') . $filenameToStore);
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
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
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
                    $btn .= '<a href="' . route('events.show', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                    $btn .= '<a href="' . route('events.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
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
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
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
                    $btn .= '<a href="' . route('events.show', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                    $btn .= '<a href="' . route('events.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
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
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
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
                    $btn .= '<a href="' . route('events.show', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                    $btn .= '<a href="' . route('events.edit', $row->id) . '" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                    $btn .= '<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'category_name', 'status'])
                ->make(true);
        }

        return view('admin.events.pelatihan');
    }

    // function dataAbsensi(Request $request, $id)
    // {
    //     $id = Events::findOrFail($id);
    //     if ($request->ajax()) {
    //         $data = Absensi::select('event_id')->where('event_id', $id->id)->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('name', function ($row) {
    //                 // Ambil informasi pengguna berdasarkan event_id
    //                 $name = User::where('event_id', $row->event_id)->first();
    //                 // Kembalikan nama pengguna
    //                 return $name->name;
    //             })
    //             ->addColumn('email', function ($row) {
    //                 // Ambil informasi pengguna berdasarkan event_id
    //                 $email = User::where('event_id', $row->event_id)->first();

    //                 // Kembalikan email pengguna
    //                 return $email->email;
    //             })
    //             ->addColumn('pekerjaan', function ($row) {
    //                 // Ambil informasi pengguna berdasarkan event_id
    //                 $pekerjaan = User::where('event_id', $row->event_id)->first();
    //                 $kerja = Pekerjaan::find($pekerjaan->pekerjaan_id);
    //                 // Kembalikan pekerjaan pengguna
    //                 return $kerja->name;
    //             })
    //             ->addColumn('jenis_kelamin', function ($row) {
    //                 // Ambil informasi pengguna berdasarkan event_id
    //                 $jenis_kelamin = User::where('event_id', $row->event_id)->first();
    //                 // Kembalikan jenis_kelamin pengguna
    //                 return $jenis_kelamin->jenis_kelamin;
    //             })
    //             ->rawColumns(['name'])
    //             ->make(true);
    //     }
    // }

    function dataAbsensi($id)
    {
        $event = Events::findOrFail($id);

        $data = Absensi::where('event_id', $event->id)
            ->with('user') // Mengambil relasi user
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('email', function ($row) {
                return $row->user->email;
            })
            ->addColumn('jenis_kelamin', function ($row) {
                return $row->user->jenis_kelamin;
            })
            ->addColumn('pendidikan', function ($row) {
                return $row->user->pendidikan;
            })
            ->addColumn('pekerjaan', function ($row) {
                return $row->user->pekerjaan ? $row->user->pekerjaan->nama : '-';
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function exportToExcel($id)
    {
        return Excel::download(new AbsensiExport($id), 'data.xlsx');
    }
}
