<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Models\Absensi;
use App\Models\PendaftaranEvents;
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

    // public function storeScanData(Request $request)
    // {
    //     $user = Auth::user();
    //     $email = $user->email;
    //     $eventId = $request->input('event_id');

    //     // Menyimpan data scan ke database
    //     $scanData = [
    //         'name' => $user->name,
    //         'user_id' => $user->id,
    //         'event_id' => $eventId,
    //         'email' => $email,
    //         // Tambahkan data lain yang perlu disimpan
    //     ];

    //     Absensi::create($scanData);
    //     return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
    // }

    public function storeScanData(Request $request)
    {
        $user = Auth::user();
        $email = $user->email;
        $eventId = $request->input('event_id');

        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->exists();

        if ($existingAbsensi) {
            return response()->json(['success' => false, 'message' => 'Anda telah melakukan absensi pada event ini sebelumnya.']);
        }
        // Menyimpan data scan ke database
        $eventRegistration = PendaftaranEvents::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->first();

        if ($eventRegistration) {
            $scanData = [
                'name' => $user->name,
                'user_id' => $user->id,
                'event_id' => $eventId,
                'email' => $email,
                // Tambahkan data lain yang perlu disimpan
            ];

            Absensi::create($scanData);
            $user = User::find($user->id);
            $badge = '';
            if ($user->point >= 5000) {
                $badge = 'Gold Badge';
            } elseif ($user->point >= 2000) {
                $badge = 'Silver Badge';
            } elseif ($user->point >= 1000) {
                $badge = 'Bronze Badge';
            }
            $user->update([
                'point' => $user->point + 1000,
                'badge' => $badge
            ]);
            return response()->json(['success' => true, 'message' => 'Data scan berhasil disimpan.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Anda belum terdaftar untuk event ini.']);
        }
    }
}
