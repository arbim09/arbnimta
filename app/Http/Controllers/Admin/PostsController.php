<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
            $data = Posts::select('*')->orderBy('created_at', 'desc');;
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
    
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048', // tambahan validasi pada input gambar
        ]);

        $posts = new Posts;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt.'_'.time().'.'.$extension;
            
            if (!$file->move(public_path('/images/posts/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
            $posts->image = $filenameToStore;
        }
        
        // Simpan data berita ke database
        
        $posts->title = $validatedData['title'];
        $posts->slug = Str::slug($validatedData['title'], '-');
        $posts->content = $validatedData['content'];
        $posts->category_id = $validatedData['category_id'];
        $posts->penulis = Auth::user()->name;
    
        // Simpan data ke database
        $posts->save();
        // Redirect ke halaman index berita
        return redirect()->route('posts.index')->with('success', 'Berita berhasil disimpan.');
    }

    // public function store(Request $request)
    // {
        
    //         $validator = Validator::make($request->all(), [
    //             'title' => 'required|max:255',
    //             'content' => 'required',
    //             'category_id' => 'required|exists:categories,id',
    //             'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);
    
    //         if ($validator->fails()) {
    //             return response()->json(['errors' => $validator->errors()->all()]);
    //         }
    
    //         $post = new Posts;
    //         $post->title = $request->title;
    //         $post->slug = Str::slug($request->title, '-');
    //         $post->content = $request->content;
    //         $post->category_id = $request->category_id;
    //         $post->penulis = Auth::user()->name;
    
    //         if ($request->hasFile('image')) {
    //             $image = $request->file('image');
    //             $filename = time() . '_' . $image->getClientOriginalName();
    //             $image->move(public_path('images/news'), $filename);
    //             $post->image = $filename;
    //         }
    
    //         $post->save();
    
    //         return response()->json(['success' => 'Berita berhasil disimpan.']);
    // }

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
        $posts = Posts::findOrFail($id);
        $category_id = Category::all();
        return view('admin.posts.edit')->with(compact('posts', 'category_id'));
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
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048', // tambahan validasi pada input gambar
        ]);
        
        $posts = Posts::findOrFail($id); // ambil data berita berdasarkan id
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $filenameToStore = $filenameWithoutExt.'_'.time().'.'.$extension;
        
            if (!$file->move(public_path('/images/posts/'), $filenameToStore)) {
                return response()->json(['error' => 'Gagal mengunggah gambar.'], 400);
            }
        
            // hapus file gambar terdahulu jika ada dan jika pengunggahan file baru berhasil
            if ($posts->image && file_exists(public_path('/images/posts/' . $posts->image))) {
                unlink(public_path('/images/posts/' . $posts->image));
            }
            $posts->image = $filenameToStore;
        }
        // Update data berita di database
        $posts->title = $validatedData['title'];
        $posts->slug = Str::slug($validatedData['title'], '-');
        $posts->content = $validatedData['content'];
        $posts->category_id = $validatedData['category_id'];
        $posts->penulis = Auth::user()->name;
        $posts->save();
        
        // Redirect ke halaman index berita
        return redirect()->route('posts.index')->with('success', 'Berita berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::findOrFail($id);

        if (file_exists(public_path('/images/posts/' . $post->image))) {
            unlink(public_path('/images/posts/' . $post->image));
        }
        $post->delete();
    }
}
