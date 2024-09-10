@extends('themes.default.layout')
@section('description'){{ categories_to_str($categories, false) }}{{ tags_to_str($tags, false) }}@endsection
@section('title')搜索 &#8211;@endsection
@section('content')
    <div class="mb-4">
        <h3>分类</h3>
        <p>
            @foreach($categories as $category)
                <a href="{{ route('search.categories', $category->slug) }}" target="_blank"><kbd>{{ $category->name }}</kbd></a>
            @endforeach
        </p>
        <h3 class="py-3">标签</h3>
        <p>
            @foreach($tags as $tag)
                <a href="{{ route('search.tags', $tag->slug) }}" target="_blank"><kbd>{{ $tag->name }}</kbd></a>
            @endforeach
        </p>
    </div>
@endsection
