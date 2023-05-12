<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Models\PendaftaranEvents;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PendaftaranEventsController extends Controller
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
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
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
        
        return view('admin.pendaftaran.kegiatan');
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
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
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
            
        return view('admin.pendaftaran.acara');
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
                        $event_name = "<a href='" . route('events.show', $row->event_id) . "'>" . $row->event_name . "</a>";
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
        
        return view('admin.pendaftaran.pelatihan');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PendaftaranEvents::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.pendaftaran.index');
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
        //
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
