@extends('themes.default.layout')
@section('title')
    搜索 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        @foreach($pinnedArticles as $article)
            <article class="blog-post">
                <h3 class="blog-post-title">[置顶]<a href="{{ route('articles.show', $article->id) }}"
                                                     class="text-decoration-none link-secondary">{{ $article->title }}</a>
                </h3>
                <p class="blog-post-meta">{{ $article->created_at->diffForHumans() }}</p>
            </article>
        @endforeach
        @foreach($articles as $article)
            <article class="blog-post">
                <h3 class="blog-post-title"><a href="{{ route('articles.show', $article->id) }}"
                                               class="text-decoration-none link-secondary">{{ $article->title }}</a>
                </h3>
                <p class="blog-post-meta">{{ $article->author->name }}
                    写于{{ $article->created_at->diffForHumans() }}</p>
            </article>
        @endforeach
        {{ $articles->links() }}
    </div>
@endsection
