@extends('themes.default.layout')
@section('description')
    {{ $page->post_excerpt }}
@endsection
@section('author')
    {{ $page->author->name }}
@endsection
@section('title')
    {{ $page->title }}
@endsection
@section('content')
    <div class="row g-5">
        <div class="col-md-12">
            <article class="blog-post">
                <h1 class="mb-1">{{ $page->title }}</h1>
                <p class="text-muted fst-italic">
                    {{ $page->author->name }} 发布于 {{ $page->published_at->format('Y.m.d') }}
                    @if($page->published_at < $page->updated_at)
                        ，最后更新于 {{ $page->updated_at->format('Y.m.d') }}
                    @endif
                </p>
                {!! App\One\EditorJs\Facades\LaravelEditorJs::render($page->body) !!}
            </article>
        </div>
    </div>
@endsection
