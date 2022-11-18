@extends('themes.default.layout')
@section('title'){{ $article->title }}@endsection
@section('content')
    <div class="row g-5">
        <div class="col-md-12">
            <article class="blog-post">
                <h1 class="blog-post-title mb-1">{{ $article->title }}</h1>
                <p class="blog-post-meta"><a class="link-secondary" href="{{ url()->current() }}#author">{{ $article->author->name }}</a> 写于 {{ $article->created_at->diffForHumans() }} </p>
                {!! App\One\EditorJs\Facades\LaravelEditorJs::render($article->body) !!}
             </article>
        </div>
    </div>
    <div id="author"  class="row g-4 mt-2">
        <div class="col-md-12">
            <div class="p-4 mb-3 bg-light rounded">
                <div class="" style="display: flex">
                    <div class="avatar" ><img class="img-rounded img-fluid" src="{{ $article->author->avatar ? Storage::disk('public')->url($article->author->avatar) : Avatar::create($article->author->name)->setBackground('#adb5bd')->toBase64() }}" alt=""></div>
                    <div style="margin: 0 12px;">
                        <h4>{{ $article->author->name }}</h4>
                        <p class="text-muted">{{ $article->author->bio ?: '暂无个人简介' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            @if($prev)
                <p><a class="link-secondary" href="{{ route('articles.show', $prev->id) }}">上一篇：{{ $prev->title }}</a></p>
            @endif
            @if($next)
                <p><a class="link-secondary" href="{{ route('articles.show', $next->id) }}">下一篇：{{ $next->title }}</a></p>
            @endif
        </div>
    </div>
    @include('themes.default.comment', ['model' => $article])
@endsection
