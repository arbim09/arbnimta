<?php

namespace App\Http\Controllers\Pengurus;

use Illuminate\Http\Request;
use App\Models\PendaftaranEvents;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PendaftaranController extends Controller
{
    public function kegiatan(Request $request)
    {
        if ($request->ajax()) {
            $data = PendaftaranEvents::select('pendaftaran_events.*', 'events.name as event_name')
                ->leftJoin('events', 'pendaftaran_events.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 3)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function($row){
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('event.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        
        return view('pengurus.pendaftaran.kegiatan');
    }

    public function acara(Request $request)
    {
        if ($request->ajax()) {
            $data = PendaftaranEvents::select('pendaftaran_events.*', 'events.name as event_name')
                ->leftJoin('events', 'pendaftaran_events.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 2)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function($row){
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('event.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
            
        return view('pengurus.pendaftaran.acara');
    }

    public function pelatihan(Request $request)
    {
        if ($request->ajax()) {
            $data = PendaftaranEvents::select('pendaftaran_events.*', 'events.name as event_name')
                ->leftJoin('events', 'pendaftaran_events.event_id', '=', 'events.id')
                ->where('events.category_id', '=', 1)
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('events_name', function($row){
                    if ($row->event_id) {
                        $event_name = "<a href='" . route('event.show', $row->event_id) . "'>" . $row->event_name . "</a>";
                    } else {
                        $event_name = "-";
                    }
                    return $event_name;
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="row">';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'events_name'])
                ->make(true);
        }
        
        return view('pengurus.pendaftaran.pelatihan');
    }

    public function destroy($id)
    {
        try {
            $pendaftaran = PendaftaranEvents::findOrFail($id);
            $pendaftaran->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }
}
