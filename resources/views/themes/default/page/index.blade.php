@extends('themes.default.layout')
@section('title')
    页面 &#8211;
@endsection
@section('content')
<ul>
    @foreach($pages as $page)
        <li>
            <small>{{ $page->published_at->format('Y年m月d日') }}</small> »
            <a href="{{ route('pages.show', $page->slug_id) }}">{{ $page->title }}</a>
        </li>
    @endforeach
</ul>
@endsection
