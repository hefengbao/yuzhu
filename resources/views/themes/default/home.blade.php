@inject('options', 'App\Services\OptionService')
@extends('themes.default.layout')
@section('description')
{{ $options->autoload()['description'] }}
@endsection
@section('content')
    <div class="row mb-2">
        @foreach($tweets as $tweet)
            <div class="col-md-6">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <div class="mb-1 text-muted">
                            {{ $tweet->author->name }}写于{{ $tweet->created_at->format('Y.m.d') }}
                        </div>
                        <p class="card-text mb-auto">{{ Str::limit($tweet->body) }}</p>
                        <a href="{{ route('tweets.show', $tweet->slug_id) }}" class="link-secondary" target="_blank">继续阅读 →</a>
                    </div>
                </div>
            </div>
        @endforeach
            @if($tweets->count()==2)
                <p><a href="{{ route('tweets.index') }}" class="link-dark">更多微博 →</a></p>
            @endif
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            @foreach($articles as $article)
                <p><span class="fst-italic text-secondary">{{ $article->published_at->format('Y.m.d') }}&nbsp;&nbsp;</span>
                    <a href="{{ route('articles.show', $article->slug_id) }}" class="link-dark" target="_blank">
                        {{ $article->title }}
                    </a>
                </p>
            @endforeach
            @if($articles->count()==8)
                <p><a href="{{ route('articles.index') }}" class="link-dark">更多文章 →</a></p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4">
                    <ol class="list-unstyled">
                        @foreach($pages as $page)
                            <li>
                                <a href="{{ route('pages.show', $page->slug_id) }}" target="_blank" class="link-dark">{{ $page->title }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
