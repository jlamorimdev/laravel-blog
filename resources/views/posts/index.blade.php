@extends('layouts.app')

@section('content')
<div class="container">
  
<div id="app">
  </div>
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
                    <post-list posts="{{ $posts }}"></post-list>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection