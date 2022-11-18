@extends('themes.default.layout')
@section('description')
    {{ $page->post_excerpt }}
@endsection
@section('author')
{{ $page->author->name }}
@endsection
@section('title')
    {{ $page->post_title }}
@endsection
@section('content')
    <div class="row mb-2">
        
    </div>
@endsection
