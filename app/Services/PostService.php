<?php
namespace App\Services;

use App\Post;
use DB;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function create($request)
    {
        $nomearquivo = '';

        if($request->hasFile('image')){
            $imagem = $request->file('image');
            $nomearquivo = time().".".$imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $nomearquivo,
            'is_published' => $request->is_published,
            'author' => Auth::user()->name,
            
        ]);

        foreach ($request->tags as $tag) {
            if(isset($tag))
            {
                DB::table('tag_post')->insert([
                    'tag_id' => $tag,
                    'post_id' => $post->id
                ]);
            }
        }

        return $post;
    }

    public function update($id, $request)
    {
        $post = Post::find($id);
        $nomearquivo = $post->image;

        if($request->hasFile('image')){
            $imagem = $request->file('image');
            $nomearquivo = time().".".$imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }

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
        return  $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'is_published' => $request->is_published,
            'image' => $nomearquivo,
            'author' => Auth::user()->name
        ]);;
    }

    public function delete($id)
    {   
        $post = Post::find($id);
        $post->delete();

        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        return $post;
    }
}