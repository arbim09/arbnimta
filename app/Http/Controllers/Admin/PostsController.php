<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Posts::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category_name', function($row){
                        return $row->category ? $row->category->name : '-';
                    })
                    ->addColumn('judul', function($q){
                        $judul = "<div class='text-left'><a class='btn btn-link btn-sm text-primary' title='Detail' href='/admin/posts/" . $q->id . "/'>$q->title</a></div>";;
                        return $judul;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<div class="row">';
                        // $btn .= '<a href="'.route('posts.show', $row->id).'" class="btn btn-link btn-sm text-primary" title="Detail"><i class="far fa-eye"></i>&nbsp</a>';
                        $btn .= '<a href="'.route('posts.edit', $row->id).'" class="btn btn-link btn-sm text-primary" title="Edit"><i class="fas fa-pen-fancy"></i>&nbsp</a>';
                        $btn .= '<button onclick="deleteData('.$row->id.')" class="btn btn-link btn-sm text-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'category_name', 'judul'])
                    ->make(true);
        }
        
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_id = Category::all();
        return view('admin.posts.create')->with(compact('category_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        // $validatedData = $request->validate([
        //     'title' => 'required|max:255',
        //     'content' => 'required',
        //     'category_id' => 'required|exists:categories,id',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // tambahan validasi pada input gambar
        // ]);

        // $posts = new Posts;
        // Upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = date('mdYHis') . Str::random(5) . '.' . $file->extension();
            
            if (!$file->move(public_path('/images/news/'), $filename)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            // $posts->image = $filename;
        }
        // if($request->hasFile('image')){
        //     $foto = $request->image->store('posts');
        // }
        
        // Simpan data berita ke database
        
        // $posts->title = $validatedData['title'];
        // $posts->slug = Str::slug($validatedData['title'], '-');
        // $posts->content = $validatedData['content'];
        // $posts->category_id = $validatedData['category_id'];
        // $posts->penulis = Auth::user()->name;
        // $posts->image = $request->file('image');
    
        // Simpan data ke database
        // $posts->save();
        
        // Redirect ke halaman index berita
        return redirect()->route('posts.index')->with('success', 'Berita berhasil disimpan.');
        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Posts::findOrFail($id);
        return view('admin.posts.show')->with(compact('posts'));
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
