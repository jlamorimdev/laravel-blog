@extends('website.master')

@section('content')
<!-- Page Header -->
<header class="masthead" style="background-image: url({{ asset('website/img/home-bg.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>Rockbuzz Teste</h1>
          <span class="subheading">Theme Blog for test rockbuzz</span>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 mx-auto">
      @foreach($posts as $post)
      <div class="post-preview">
        <a href="{{ url('post/' . $post->slug)}}">
          <h2 class="post-title">
            {{ $post->title }}
          </h2>
          <h3 class="post-subtitle">
            {{ str_limit( $post->body , 100 ) }}
          </h3>
        </a>
        <p class="post-meta">Posted by
        <b>{{ $post->author }}</b>
          on {{ date('M d Y', strtotime($post->created_at)) }}
          <span class="post-tag">
            Tag:
            @foreach(\App\Tag::all() as $tag)
              @if($post->has_tag($tag->id))
                <a href="{{ url('tag/' . $tag->id)}}">{{ $tag->name }}</a>
              @endif
            @endforeach
          </span>
        </p>
      </div>
      <hr>
      @endforeach
      <!-- Pager -->
      <div class="clearfix mt-4">
        {{ $posts->links() }}
      </div>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="tag">
        <h2 class="tag-title">Tags</h2>
        <ul class="tag-list">
          @foreach($tags as $tag)
          <li><a href="{{ url('tag/' . $tag->id)}}">{{$tag->name}}</a></li>
          @endforeach
        </ul>
      </div>

    </div>
  </div>
</div>
@endsection()