<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        $posts = Post::all();

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function criar()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function salvar(Request $request)
    {   
        $nomearquivo = '';
        
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasFile('image')){
            $imagem = $request->file('image');
            $nomearquivo = time().".".$imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }


        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $nomearquivo,
            'author' => Auth::user()->name,
            
        ]);

        $post = Post::where('title', $request->title)->get();
        
        foreach ($request->tags as $tag) {
            if(isset($tag))
            {
                DB::table('tag_post')->insert([
                    'tag_id' => $tag,
                    'post_id' => $post[0]->id
                ]);
            }
        }
        

        return redirect('posts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        $post = Post::find($id);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        $nomearquivo = $post->image;

        if($request->hasFile('image')){
            $imagem = $request->file('image');
            $nomearquivo = time().".".$imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $nomearquivo,
            'author' => Auth::user()->name
        ]);

        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        foreach ($request->tags as $tag) {
            if(isset($tag))
            {
                DB::table('tag_post')->insert([
                    'tag_id' => $tag,
                    'post_id' => $post->id
                ]);
            }
        }

        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletar($id)
    {
        $post = Post::find($id);

        $post->delete();

        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        return redirect('posts');
    }
}
