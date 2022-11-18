@extends('themes.default.layout')
@section('description')
    @parent
@stop
@section('keywords')
    @parent
@stop
@section('author')
    @parent
@stop
@section('title')
    @parent
@stop
@section('content')
    <div class="mb-4">
        <h3>分类</h3>
        @foreach($categories as $category)
            <a href="{{ route('search.categories', $category->slug) }}"><span class="badge rounded-pill text-bg-secondary">{{ $category->name }}</span></a>
        @endforeach
        <h3 class="py-3">标签</h3>
        @foreach($tags as $tag)
            <a href="{{ route('search.tags', $tag->slug) }}"><span class="badge rounded-pill text-bg-secondary">{{ $tag->name }}</span></a>
        @endforeach
    </div>
@endsection
