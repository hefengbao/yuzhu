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
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4">
                    <ol class="list-unstyled">
                        @foreach($pages as $page)
                            <li>
                                <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="link-secondary">{{ $page->title }}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
