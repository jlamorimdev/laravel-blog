@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts Edit</div>

                <div class="card-body">
                    <form action="{{route('posts.update', $post->slug)}}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="text-muted">Title</label>
                            <input id="title" type="text" value="{{ $post->title }}" name="title" class="form-control">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('body') ? ' has-error' : '' }}">
                            <label for="body" class="text-muted">Body</label>
                            <textarea id="body" name="body" rows="10" class="form-control">{{ $post->body }}</textarea>
                            @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('slug') ? ' has-error' : '' }}">
                            <label for="slug" class="text-muted">Slug</label>
                            <input id="slug" type="text" value="{{ $post->slug }}" name="slug" class="form-control">
                            @if ($errors->has('slug'))
                            <span class="help-block">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('is_published') ? ' has-error' : '' }}">
                            <label for="is_published" class="text-muted">Publish</label>
                            <select id="is_published" type="text" name="is_published" class="form-control">
                                <option value="1" {{$post->is_published == 1 ? 'selected' : ''}}>Publish</option>
                                <option value="0" {{$post->is_published == 0 ? 'selected' : ''}}>Draft</option>
                            </select>
                            @if ($errors->has('is_published'))
                            <span class="help-block">
                                <strong>{{ $errors->first('is_published') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="tags" class="text-muted">Tags</label>
                            <select id="tags" type="text" name="tags[]" multiple class="form-control">
                                @foreach(\App\Tag::all() as $tag)
                                <option value="{{ $tag->id }}" @if($post->has_tag($tag->id)) selected @endif>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tags'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tags') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="text-muted">Image</label>
                            <input id="image" type="file" name="image" class="form-control-file"></input>
                            @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                            @endif
                        </div>
                        <a href="{{ route('posts.index') }}" class="btn btn-danger">Voltar</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection