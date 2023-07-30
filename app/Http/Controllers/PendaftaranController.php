<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Category;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use App\Models\PendaftaranEvents;
use Illuminate\Support\Facades\DB;
use Dotenv\Exception\ValidationException;
use Symfony\Contracts\EventDispatcher\Event;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEventsByCategory($id)
    {
        $events = DB::table("events")
            ->where("category_id", $id)
            ->pluck('name', 'id');
        return json_encode($events);
    }

    public function index(Request $request, $event_id)
    {
        $events     = Events::findOrfail($event_id);
        // $events     = Events::where('status', true)->get();
        $category   = Category::all();
        $pekerjaan  = Pekerjaan::all();
        return view('pendaftaran', compact('category', 'events', 'pekerjaan'));
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
        $user_id = auth()->user()->id;
        $event_id = $request->event_id;

        // Cek apakah pengguna sudah terdaftar pada acara yang sama
        $existingPendaftaran = PendaftaranEvents::where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        if ($existingPendaftaran) {
            // Jika sudah terdaftar, lakukan tindakan yang sesuai
            return redirect()->route('form-pendaftaran', $event_id)->with('warning', 'Anda Telah Terdaftar Pada Event Ini');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required|string',
        ]);

        $pendaftaran = new PendaftaranEvents();
        $pendaftaran->name = $request->name;
        $pendaftaran->user_id = auth()->user()->id;
        $pendaftaran->event_id = $event_id;
        $pendaftaran->email = $request->email;
        $pendaftaran->pendidikan = $request->pendidikan;
        $pendaftaran->organisasi = $request->organisasi;
        $pendaftaran->no_hp = $request->no_hp;
        $pendaftaran->save();

        // Debugging atau hapus baris berikut jika tidak diperlukan
        // dd($pendaftaran);

        return redirect()->route('form-pendaftaran', $event_id)->with('success', 'Selamat Anda Berhasil Mendaftar!');
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
