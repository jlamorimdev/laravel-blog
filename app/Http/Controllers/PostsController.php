<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequestStore;
use App\Http\Requests\PostRequestUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PostService;

class PostsController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar()
    {
        $posts = Post::orderBy('id', 'DESC')->get();

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
     * @param  \App\Http\Requests\PostRequestStore $request
     * @return \Illuminate\Http\Response
     */
    public function salvar(PostRequestStore $request)
    {
        if ($this->postService->create($request)) {
            return redirect('posts')->with('success', 'Post Cadastrado com Sucesso');;
        } else {
            return redirect('posts')->with('danger', 'Ocorreu um erro ao Cadastrar Post');;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequestUpdate  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function atualizar(PostRequestUpdate $request, $slug)
    {
        if ($this->postService->update($slug, $request)) {
            return redirect('posts')->with('success', 'Post Atualizado com Sucesso');;
        } else {
            return redirect('posts')->with('danger', 'Ocorreu um erro ao Atualizar Post');;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletar($slug)
    {
        if ($this->postService->delete($slug)) {
            return redirect('posts')->with('success', 'Post Deletado com Sucesso');;
        } else {
            return redirect('posts')->with('danger', 'Ocorreu um erro ao Deletar Post');;
        }
    }
}
