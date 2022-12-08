@extends('themes.default.layout')
@section('title')
文章 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        @foreach($pinnedArticles as $article)
            <p>
                [置顶]
                <a href="{{ route('articles.show', $article->slug) }}" class="link-secondary">
                    {{ $article->title }}
                </a>
            </p>
        @endforeach
        @foreach($articles as $article)
            <p> {{ $article->published_at->format('Y.m.d') }}
                <a href="{{ route('articles.show', $article->slug) }}" class="link-secondary">
                    {{ $article->title }}
                </a>
            </p>
        @endforeach
        {{ $articles->links() }}
    </div>
@endsection
