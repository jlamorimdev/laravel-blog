<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $post = Post::where('title', $request->title)->get();

        foreach ($request->tags as $tag) {
            \DB::table('tag_post')->insert([
                'tag_id' => $tag->id,
                'post_id' => $post[0]->id
            ]);
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

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        \DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        foreach ($request->tags as $tag_id) {
            \DB::table('tag_post')->insert([
                'tag_id' => $tag_id,
                'post_id' => $post->id
            ]);
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

        \DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        return redirect('posts');
    }
}
