<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('absensi', compact('user'));
    }

    public function scanQR(Request $request)
    {
        // Mendapatkan data hasil pemindaian QR dari request
        $qrCodeData = $request->input('qrCodeData');

        // Verifikasi keaslian kode QR dan proses pengabsenan sesuai kebutuhan
        // ...

        // Mengembalikan respons yang sesuai
        return response()->json(['success' => true, 'message' => 'Absensi berhasil.']);
    }

    public function kegiatan()
    {
        $id_category = 3; // ganti dengan id kategori yang ingin ditampilkan
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->get();
        return view('absensi.kegiatan', ['events' => $events]);
    }

    public function submitKegiatan(Request $request)
    {
        $absen = new Absensi;
        //tambahin buat ngambil data user_id dari user yang sedang login
        $absen->name = $request->name;
        $absen->email = $request->email;
        $absen->event_id = $request->event_id;
        $absen->save();
    }

    public function acara()
    {
        $id_category = 2; // ganti dengan id kategori yang ingin ditampilkan
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->get();
        return view('absensi.acara', ['events' => $events]);
    }

    public function submitAcara(Request $request)
    {
        $absen = new Absensi;
        //tambahin buat ngambil data user_id dari user yang sedang login
        $absen->name = $request->name;
        $absen->email = $request->email;
        $absen->event_id = $request->event_id;
        $absen->save();
    }

    public function pelatihan()
    {
        $id_category = 1; // ganti dengan id kategori yang ingin ditampilkan
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->get();
        return view('absensi.pelatihan', ['events' => $events]);
    }

    public function submitPelatihan(Request $request)
    {
        $absen = new Absensi;
        //tambahin buat ngambil data user_id dari user yang sedang login
        $absen->name = $request->name;
        $absen->email = $request->email;
        $absen->event_id = $request->event_id;
        $absen->save();
    }


    public function camera()
    {
        $user = Auth::user();
        $events = Events::all();
        return view('absensi', compact('user', 'events'));
    }

    public function storeScanData(Request $request)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $email = $user->email;
        $eventId = $request->input('event_id');

        // Menyimpan data scan ke database
        $scanData = [
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
            'event_id' => $eventId,
            'email' => $email,
            // Tambahkan data lain yang perlu disimpan
        ];
        Absensi::create($scanData);
        return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    }
}
