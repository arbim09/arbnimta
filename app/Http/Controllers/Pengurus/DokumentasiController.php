<?php

namespace App\Http\Controllers\Pengurus;

use App\Models\Events;
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
        $events = Events::where('status', false)->get();
        return view('pengurus.dokumentasi.create', compact('events'));
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
            'gambar1' => 'required',
        ]);

        $dokumentasi = new Dokumentasi();

        $dokumentasi->event_id = $request->event_id;
        $gambar1 = $request->file('gambar1');
        $gambar2 = $request->file('gambar2');
        $gambar3 = $request->file('gambar3');
        $gambar4 = $request->file('gambar4');
        $gambar5 = $request->file('gambar5');
        $path = 'images/dokumentasi';
        if ($gambar1 !== null) {
            $dokumentasi->gambar1 = time() . '_gambar1_' . $gambar1->getClientOriginalName();
        }
        if ($gambar1 !== null) {
            if ($gambar1->move($path, $dokumentasi->gambar1) == false) {
                print $gambar1->getErrorMessage();
                die;
            }
        }
        if ($gambar2 !== null) {
            $dokumentasi->gambar2 = time() . '_gambar2_' . $gambar2->getClientOriginalName();
        }
        if ($gambar2 !== null) {
            if ($gambar2->move($path, $dokumentasi->gambar2) == false) {
                print $gambar2->getErrorMessage();
                die;
            }
        }
        if ($gambar3 !== null) {
            $dokumentasi->gambar3 = time() . '_gambar3_' . $gambar3->getClientOriginalName();
        }
        if ($gambar3 !== null) {
            if ($gambar3->move($path, $dokumentasi->gambar3) == false) {
                print $gambar3->getErrorMessage();
                die;
            }
        }
        if ($gambar4 !== null) {
            $dokumentasi->gambar4 = time() . '_gambar4_' . $gambar4->getClientOriginalName();
        }
        if ($gambar4 !== null) {
            if ($gambar4->move($path, $dokumentasi->gambar4) == false) {
                print $gambar4->getErrorMessage();
                die;
            }
        }
        if ($gambar5 !== null) {
            $dokumentasi->gambar5 = time() . '_gambar5_' . $gambar5->getClientOriginalName();
        }
        if ($gambar5 !== null) {
            if ($gambar5->move($path, $dokumentasi->gambar5) == false) {
                print $gambar5->getErrorMessage();
                die;
            }
        }
        $dokumentasi->save();

        return redirect()->route('event.index')->with('error', 'Tidak ada gambar yang diunggah.');
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
        $dokumentasi = Dokumentasi::findOrfail($id);
        $events = Events::where('status', false)->get();
        return view('pengurus.dokumentasi.edit', compact('dokumentasi', 'events'));
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
        $request->validate([
            'event_id' => 'required',
            'gambar1' => 'sometimes',
        ]);

        $dokumentasi = Dokumentasi::find($id);
        $dokumentasi->event_id = $request->event_id;
        $gambar1 = $request->file('gambar1');
        $gambar2 = $request->file('gambar2');
        $gambar3 = $request->file('gambar3');
        $gambar4 = $request->file('gambar4');
        $gambar5 = $request->file('gambar5');
        $path = 'images/dokumentasi';

        if ($gambar1 !== null) {
            if ($dokumentasi->gambar1) {
                $this->deleteImage($dokumentasi->gambar1);
            }
            $dokumentasi->gambar1 = time() . '_gambar1_' . $gambar1->getClientOriginalName();
            $gambar1->move($path, $dokumentasi->gambar1);
        }

        if ($gambar2 !== null) {
            if ($dokumentasi->gambar2) {
                $this->deleteImage($dokumentasi->gambar2);
            }
            $dokumentasi->gambar2 = time() . '_gambar2_' . $gambar2->getClientOriginalName();
            $gambar2->move($path, $dokumentasi->gambar2);
        }

        if ($gambar3 !== null) {
            if ($dokumentasi->gambar3) {
                $this->deleteImage($dokumentasi->gambar3);
            }
            $dokumentasi->gambar3 = time() . '_gambar3_' . $gambar3->getClientOriginalName();
            $gambar3->move($path, $dokumentasi->gambar3);
        }

        if ($gambar4 !== null) {
            if ($dokumentasi->gambar4) {
                $this->deleteImage($dokumentasi->gambar4);
            }
            $dokumentasi->gambar4 = time() . '_gambar4_' . $gambar4->getClientOriginalName();
            $gambar4->move($path, $dokumentasi->gambar4);
        }

        if ($gambar5 !== null) {
            if ($dokumentasi->gambar5) {
                $this->deleteImage($dokumentasi->gambar5);
            }
            $dokumentasi->gambar5 = time() . '_gambar5_' . $gambar5->getClientOriginalName();
            $gambar5->move($path, $dokumentasi->gambar5);
        }

        $dokumentasi->save();

        return redirect()->route('event.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    private function deleteImage($imagePath)
    {
        $fullImagePath = public_path($imagePath);
        if (file_exists($fullImagePath)) {
            unlink($fullImagePath);
        }
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

    public function deleteGambar1($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->gambar1) {
            // Hapus gambar 1 dari penyimpanan
            $gambar1Path = public_path('images/dokumentasi/' . $dokumentasi->gambar1);
            if (file_exists($gambar1Path)) {
                unlink($gambar1Path);
            }

            // Kosongkan field gambar1 pada entitas Dokumentasi
            $dokumentasi->gambar1 = null;
            $dokumentasi->save();

            return redirect()->back()->with('success', 'Gambar 1 berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar 1 yang tersedia.');
    }

    public function deleteGambar2($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->gambar2) {
            // Hapus gambar 2 dari penyimpanan
            $gambar2Path = public_path('images/dokumentasi/' . $dokumentasi->gambar2);
            if (file_exists($gambar2Path)) {
                unlink($gambar2Path);
            }

            // Kosongkan field gambar2 pada entitas Dokumentasi
            $dokumentasi->gambar2 = null;
            $dokumentasi->save();

            return redirect()->back()->with('success', 'Gambar 2 berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar 2 yang tersedia.');
    }

    public function deleteGambar3($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->gambar3) {
            // Hapus gambar 3 dari penyimpanan
            $gambar3Path = public_path('images/dokumentasi/' . $dokumentasi->gambar3);
            if (file_exists($gambar3Path)) {
                unlink($gambar3Path);
            }

            // Kosongkan field gambar3 pada entitas Dokumentasi
            $dokumentasi->gambar3 = null;
            $dokumentasi->save();

            return redirect()->back()->with('success', 'Gambar 3 berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar 3 yang tersedia.');
    }

    public function deleteGambar4($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->gambar4) {
            // Hapus gambar 4 dari penyimpanan
            $gambar4Path = public_path('images/dokumentasi/' . $dokumentasi->gambar4);
            if (file_exists($gambar4Path)) {
                unlink($gambar4Path);
            }

            // Kosongkan field gambar4 pada entitas Dokumentasi
            $dokumentasi->gambar4 = null;
            $dokumentasi->save();

            return redirect()->back()->with('success', 'Gambar 4 berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar 4 yang tersedia.');
    }

    public function deleteGambar5($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        if ($dokumentasi->gambar5) {
            // Hapus gambar 5 dari penyimpanan
            $gambar5Path = public_path('images/dokumentasi/' . $dokumentasi->gambar5);
            if (file_exists($gambar5Path)) {
                unlink($gambar5Path);
            }

            // Kosongkan field gambar5 pada entitas Dokumentasi
            $dokumentasi->gambar5 = null;
            $dokumentasi->save();

            return redirect()->back()->with('success', 'Gambar 5 berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada gambar 5 yang tersedia.');
    }
}
