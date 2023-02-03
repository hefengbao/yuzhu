@extends('themes.default.layout')
@section('og_date'){{ $page->updated_at }}@endsection
@section('og_title'){{ $page->title }}@endsection
@section('og_description'){{ $page->excerpt }}@endsection
@section('og_author'){{ $page->author->name ?? '' }}@endsection
@section('description'){{ $page->excerpt }}@endsection
@section('author'){{ $page->author->name }}@endsection
@section('title'){{ $page->title }}@endsection
@section('content')
    <div class="row g-5">
        <div class="col-md-12">
            <article class="blog-post">
                <h1 class="mb-1">{{ $page->title }}</h1>
                <p class="text-muted fst-italic">
                    {{ $page->author->name }}
                    @if($page->published_at)
                        发布于 {{ $page->published_at->format('Y.m.d') }}
                        @if($page->published_at < $page->updated_at)
                            ，最后更新于 {{ $page->updated_at->format('Y.m.d') }}
                        @endif
                    @endif
                </p>
                <div class="blog-post-body">
                    {!! $page->body !!}
                </div>
            </article>
        </div>
    </div>
@endsection
