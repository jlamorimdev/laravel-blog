@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts
                    <a href="{{ url('posts/create') }}" class="btn btn-sm btn-primary float-right">Create</a>
                </div>

                <div class="card-body">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                    @endif
                    @if(count($errors) > 0 )
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>

                    </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th>Title</th>
                                <th style="width: 100px">Author</th>
                                <th>Image</th>
                                <th style="width: 130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->author }}</td>
                                <td><img src="{{url('img/posts/' .$post->image )}}" alt="Image" class="img-thumbnail"></td>
                                <td>
                                    <a href="{{ url('posts/edit/' . $post->slug) }}" class="btn btn-sm btn-primary">edit</a>
                                    <a href="{{ url('posts/destroy/' . $post->slug) }}" class="btn btn-sm btn-danger">destroy</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection