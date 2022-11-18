@extends('themes.default.layout')
@section('title')
    {{ $tag->name }} - @parent
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>标签：{{ $tag->name }}</h4>
        </div>
    </div>
    @foreach($posts as $post)

    @endforeach
    {!! $posts->links() !!}
@stop
