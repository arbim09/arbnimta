<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class AnggotaPengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
             ->select('*')
             ->where('role', '=', 'anggota')
             ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        // $btn .= '<a href="'.route('admin.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        // $btn .= '<a href="'.route('admin.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
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
