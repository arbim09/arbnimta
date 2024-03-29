<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Events;
use App\Models\Banners;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banners = Banners::where('is_show', true)->get();
        $berita = Posts::orderBy('created_at', 'desc')->paginate(6);
        // $berita = Posts::paginate(6);
        // $berita = Posts::orderBy('created_at', 'desc')->take(6)->get();

        if ($request->ajax()) {
            $view = view('load_more_berita', compact('berita'))->render();
            return response()->json(['html' => $view]);
        }
        return view('welcome')->with(compact('banners', 'berita'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact');
    }


    public function berita($slug)
    {
        $posts = Posts::where('slug', $slug)->firstOrFail();
        return view('berita')->with(compact('posts'));;
    }


    public function contact()
    {
        return view('contact');
    }

    public function loadMoreBerita(Request $request)
    {
        $berita = Posts::orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('load_more_berita', compact('berita'));
        }

        $banners = Banners::where('is_show', true)->get();
        return view('welcome', compact('banners', 'berita'));
    }

    public function kegiatan(Request $request)
    {
        $id_category = 3; // ganti dengan id kategori yang ingin ditampilkan
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderByDesc('events.created_at')
            ->paginate(6);

        if ($request->ajax()) {
            $view = view('load_more_kegiatan', compact('events'))->render();

            return response()->json(['html' => $view]);
        }

        return view('kegiatan', ['events' => $events]);
    }

    public function loadMoreKegiatan(Request $request)
    {
        $id_category = 3; // Ganti dengan id kategori yang ingin ditampilkan
        $currentPage = $request->query('page');

        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderByDesc('events.created_at')
            ->paginate(6);

        if ($request->ajax()) {
            return view('load_more_kegiatan', compact('events'));
        }
        return view('kegiatan', compact('events'));
    }

    public function showKegiatan($id)
    {
        $events = Events::find($id);
        $eventId = $id;
        $dokumentasi = Dokumentasi::where('event_id', $eventId)->first();
        return view('show_kegiatan', compact('events', 'dokumentasi'));
    }

    public function pelatihan(Request $request)
    {
        $id_category = 1;
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderByDesc('events.created_at')
            ->paginate(6);

        if ($request->ajax()) {
            $view = view('load_more_pelatihan', compact('events'))->render();

            return response()->json(['html' => $view]);
        }

        return view('pelatihan', ['events' => $events]);
    }

    public function loadMorePelatihan(Request $request)
    {
        $id_category = 1; // Ganti dengan id kategori yang ingin ditampilkan
        $currentPage = $request->query('page');

        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderByDesc('events.created_at')
            ->paginate(6);

        if ($request->ajax()) {
            return view('load_more_pelatihan', compact('events'));
        }
        return view('pelatihan', compact('events'));
    }

    public function showPelatihan($id)
    {
        $events = Events::find($id);
        $eventId = $id;
        $dokumentasi = Dokumentasi::where('event_id', $eventId)->first();
        return view('show_pelatihan', compact('events', 'dokumentasi'));
    }
    public function acara(Request $request)
    {
        $id_category = 2;
        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        if ($request->ajax()) {
            $view = view('load_more_acara', compact('events'))->render();

            return response()->json(['html' => $view]);
        }

        return view('acara', ['events' => $events]);
    }

    public function loadMoreAcara(Request $request)
    {
        $id_category = 2; // Ganti dengan id kategori yang ingin ditampilkan
        $currentPage = $request->query('page');

        $events = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('categories.id', '=', $id_category)
            ->where('events.is_show', true)
            ->select('events.*', 'categories.name as category_name')
            ->orderByDesc('events.created_at')
            ->paginate(6);

        if ($request->ajax()) {
            return view('load_more_acara', compact('events'));
        }
        return view('acara', compact('events'));
    }

    public function showAcara($id)
    {
        $events = Events::find($id);
        $eventId = $id;
        $dokumentasi = Dokumentasi::where('event_id', $eventId)->first();
        return view('show_acara', compact('events', 'dokumentasi'));
    }
}
