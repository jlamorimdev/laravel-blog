@extends('website.master')

@section('content')
    <!-- Page Header -->
    <header class="masthead" style="background-image: url({{ asset('img/posts/'.$post->image) }}">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1>{{ $post->title }}</h1>
              <span class="meta">Posted by
                <a href="#">{{ $post->author }}</a>
                on {{ date('M d Y', strtotime($post->created_at)) }}</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Post Content -->
    <article>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
           {{ $post->body }}
          </div>
        </div>
      </div>
    </article>
@endsection