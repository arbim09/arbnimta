<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Posts;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function berita($slug)
    {
        $posts = Posts::where('slug', $slug)->firstOrFail();
        return view('berita')->with(compact('posts'));;
    }

    public function menubell()
    {
       return view('layout.anggotaLayouts.menuBell');
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

    // public function loadMoreBerita(Request $request)
    // {
    //     $page = $request->input('page');
    //     $perPage = 6;
    //     $skip = ($page - 1) * $perPage;
    
    //     if ($request->ajax()) {
    //         $beritaBaru = Posts::orderBy('created_at', 'desc')->skip($skip)->take($perPage)->get();
    //         $beritaLama = Posts::orderBy('created_at', 'asc')->limit($skip)->get();
    //         $berita = $beritaBaru->concat($beritaLama)->sortByDesc('created_at');
    
    //         return response()->json(['html' => view('load_more_berita', compact('berita'))->render()]);
    //     }
    // }
}
