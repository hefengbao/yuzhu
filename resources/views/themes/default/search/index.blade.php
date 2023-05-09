@extends('themes.default.layout')
@section('description'){{ categories_to_str($categories, false) }}{{ tags_to_str($tags, false) }}@endsection
@section('title')搜索 &#8211;@endsection
@section('content')
    <div class="mb-4">
        <h3>分类</h3>
        @foreach($categories as $category)
            <a href="{{ route('search.categories', $category->slug) }}" target="_blank"><span class="badge rounded-pill text-bg-secondary p-2 m-2">{{ $category->name }}</span></a>
        @endforeach
        <h3 class="py-3">标签</h3>
        @foreach($tags as $tag)
            <a href="{{ route('search.tags', $tag->slug) }}" target="_blank"><span class="badge rounded-pill text-bg-secondary p-2 m-2">{{ $tag->name }}</span></a>
        @endforeach
    </div>
@endsection
