<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'photo' => 'required|array|min:1|max:5',
            'photo.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event_id = $request->event_id;

        if ($request->hasFile('photo')) {
            $photos = [];
            foreach ($request->file('photo') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->store('images/dokumentasi', 'public');
                $photos[] = [
                    'event_id' => $event_id,
                    'photo' => $filename,
                    'path' => $path,
                ];
            }

            Dokumentasi::insert($photos);

            return redirect()->back()->with('success', 'Gambar berhasil diunggah!');
        }



        return redirect()->back()->with('error', 'Tidak ada gambar yang diunggah.');
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
