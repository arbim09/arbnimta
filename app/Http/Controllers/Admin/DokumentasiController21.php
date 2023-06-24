<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    /**
     * Store uploaded images for an event.
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
        $photos = [];

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $filename = $photo->getClientOriginalName();
                $path = $photo->store('dokumentasi', 'public/images');

                $photos[] = [
                    'event_id' => $event_id,
                    'filename' => $filename,
                    'path' => $path,
                ];
            }

            Dokumentasi::insert($photos);

            return redirect()->back()->with('success', 'Gambar berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar yang diunggah.');
    }
}
