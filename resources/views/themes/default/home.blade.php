@inject('options', 'App\Services\OptionService')
@extends('themes.default.layout')
@section('description')
    {{ $options->autoload()['description'] }}
@endsection
@section('content')
    <div class="row mb-2">
        @foreach($tweets as $tweet)
            <div class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <div class="mb-1 text-muted">
                            {{ $tweet->author->name }}写于{{ $tweet->created_at->format('Y.m.d') }}
                        </div>
                        <p class="card-text mb-auto">{{ Str::limit($tweet->body) }}</p>
                        <a href="{{ route('tweets.show', $tweet->slug) }}" class="link-secondary text-sm">继续阅读 →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            @foreach($articles as $article)
                <p> {{ $article->created_at->format('Y.m.d') }}
                    <a href="{{ route('articles.show', $article->slug) }}" class="link-secondary">
                        {{ $article->title }}
                    </a>
                </p>
                {{--<article class="blog-post divider">
                    <h4 class="blog-post-title mb-1">
                        <a href="{{ route('articles.show', $article->id) }}" class="link-secondary">
                            {{ $article->title }}
                        </a>
                    </h4>
                    <p class="blog-post-meta">
                        {{ $article->author->name }}写于{{ $article->created_at->diffForHumans() }}
                        @if($article->categories->isNotEmpty())
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-tag" viewBox="0 0 16 16">
                                <path
                                    d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z"/>
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z"/>
                            </svg>{{ categories_to_str($article->categories, false) }}
                        @endif
                    </p>
                </article>--}}
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4">
                    <ol class="list-unstyled">
                        @foreach($pages as $page)
                            <li><a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="link-secondary">{{ $page->title }}</a></li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
