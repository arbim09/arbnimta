<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;


class AnggotaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Gate::allows('pengurus')|| Gate::allows('admin')) {
                return $next($request);
            }
            abort(403);
        });
    }
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
                        $btn .= '<a href="'.route('admin.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('admin.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '&nbsp;&nbsp;&nbsp;<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.anggota.index');
    }
}
