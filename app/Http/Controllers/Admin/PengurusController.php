<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
             ->select('*')
             ->where('role', '=', 'pengurus')
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
        
        return view('admin.pengurus.index');
    }
}
