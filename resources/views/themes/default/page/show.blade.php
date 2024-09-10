@extends('themes.default.layout')
@section('og_date'){{ $page->updated_at }}@endsection
@section('og_title'){{ $page->title }}@endsection
@section('og_description'){{ $page->excerpt }}@endsection
@section('og_author'){{ $page->author->name ?? '' }}@endsection
@section('description'){{ $page->excerpt }}@endsection
@section('author'){{ $page->author->name }}@endsection
@section('title'){{ $page->title }}@endsection
@section('content')
    <section>
        <!--标题-->
        <hgroup>
            <h1>{{ $page->title }}</h1>
            <p>
                {{ $page->author->name }}
                @if($page->published_at)
                    发布于 {{ $page->published_at->format('Y.m.d') ?? $page->creatd_at->format('Y.m.d') }}
                    @if( $page->published_at < $page->updated_at)
                        ，最后更新于 {{ $page->updated_at->format('Y.m.d') }}
                    @endif
                @endif
            </p>
        </hgroup>

        <!--内容-->
        {!! \Illuminate\Support\Str::markdown($page->body) !!}
@endsection
