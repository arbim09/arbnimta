<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Absensi::select('absensis.*', 'events.name as event_name')
                ->leftJoin('events', 'absensis.event_id', '=', 'events.id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function ($row) {
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->events_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function ($row) {
                    $btn  = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        return view('admin.absensi.index');
    }

    public function kegiatan(Request $request)
    {
        if ($request->ajax()) {
            $data = Absensi::select('absensis.*', 'events.name as event_name')
                ->leftJoin('events', 'absensis.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 3);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function ($row) {
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        return view('admin.absensi.kegiatan');
    }

    public function acara(Request $request)
    {
        if ($request->ajax()) {
            $data = Absensi::select('absensis.*', 'events.name as event_name')
                ->leftJoin('events', 'absensis.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 2);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function ($row) {
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        return view('admin.absensi.acara');
    }

    public function pelatihan(Request $request)
    {
        if ($request->ajax()) {
            $data = Absensi::select('absensis.*', 'events.name as event_name')
                ->leftJoin('events', 'absensis.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 1);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function ($row) {
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData(' . $row->id . ')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        return view('admin.absensi.pelatihan');
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

    public function destroy($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json(['message' => 'absensi tidak ditemukan'], 404);
        }
        $absensi->delete();
        return response()->json(['message' => 'absensi berhasil dihapus'], 200);
    }
}
