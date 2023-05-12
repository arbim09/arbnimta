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
                    // ->addColumn('events_name', function($row){
                    //     return $row->event_name ?? '-';
                    // })
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
                    // ->addColumn('events_name', function($row){
                    //     return $row->event_name ?? '-';
                    // })
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
                    // ->addColumn('events_name', function($row){
                    //     return $row->event_name ?? '-';
                    // })
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
