<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Post;


class WebsiteController extends Controller
{
    public function index(){
        $tags = Tag::orderBy('name', 'ASC')->get();
        $posts = Post::orderBy('id', 'DESC')->where('is_published', '1')->paginate(5);
        return view('website.index', compact('tags', 'posts'));
    }

    public function post($slug){
        $post = Post::where('slug', $slug)->first();
        if($post){
            return view('website.post', compact('post'));
        }else{
            return \Response::view('website.errors.404', array(), 404);
        }
    }

    public function tag($id){
        $tag = Tag::where('id', $id)->first();
        
        if($tag){
            $posts = $tag->posts()->orderBy('posts.id', 'DESC')->where('is_published', '1')->paginate(5);
            return view('website.tag', compact('tag', 'posts'));
        }else{
            return \Response::view('website.errors.404', array(), 404);
        }

    }
}
