<?php

namespace App\Http\Controllers;

use App\Models\Absesnsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function kegiatan(){
        $id_category = 3; // ganti dengan id kategori yang ingin ditampilkan
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->select('events.*', 'categories.name as category_name')
            ->get();
        return view('absensi.kegiatan', ['events' => $events]);
    }

    public function submitKegiatan(Request $request)
    {
        $absen = new Absesnsi;
        //tambahin buat ngambil data user_id dari user yang sedang login
        $absen->name = $request->name;
        $absen->email = $request->email;
        $absen->event_id = $request->event_id;
        $absen->save();
    }

    public function acara(){
        return view('absensi.acara');
    }

    public function pelatihan(){
        return view('absensi.pelatihan');
    }


}
