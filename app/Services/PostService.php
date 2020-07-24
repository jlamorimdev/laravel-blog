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

        if ($request->hasFile('image')) {
            $imagem = $request->file('image');
            $nomearquivo = time() . "." . $imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug,
            'image' => $nomearquivo,
            'is_published' => $request->is_published,
            'author' => Auth::user()->name,

        ]);

        if (isset($request->tags) || $request->tags != "") {
            foreach ($request->tags as $tag) {
                DB::table('tag_post')->insert([
                    'tag_id' => $tag,
                    'post_id' => $post->id
                ]);
            }
        }

        return $post;
    }

    public function update($slug, $request)
    {
        $post = Post::where('slug', $slug)->first();
        $nomearquivo = $post->image;

        if ($request->hasFile('image')) {
            $imagem = $request->file('image');
            $nomearquivo = time() . "." . $imagem->getClientOriginalExtension();
            $request->file('image')->move(public_path('./img/posts/'), $nomearquivo);
        }

        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        if (isset($request->tags) || $request->tags != "") {
            foreach ($request->tags as $tag) {
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
            'slug' => $request->slug,
            'image' => $nomearquivo,
            'author' => Auth::user()->name
        ]);;
    }

    public function delete($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $post->delete();

        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        return $post;
    }
}
