@extends('themes.default.layout')
@section('title')
    {{ $category->name }} - @parent
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>标签：{{ $category->name }}</h4>
        </div>
    </div>
    @foreach($posts as $post)

    @endforeach
    {!! $posts->links() !!}
@stop
