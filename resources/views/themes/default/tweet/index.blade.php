@extends('themes.default.layout')
@section('content')
    <div class="row mb-2">
        @foreach($tweets as $tweet)
            <div class="col-md-6">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <div class="mb-1 text-muted">{{ $tweet->created_at->diffForHumans() }}</div>
                        <p class="card-text mb-auto">{{ Str::limit($tweet->body) }}</p>
                        <a href="{{ route('tweets.show', $tweet->id) }}" class="link-secondary text-sm">继续阅读 →</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-5">
        <div class="col-md-8">
            @foreach($articles as $article)
                <article class="blog-post">
                    <h2 class="blog-post-title mb-1"><a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none link-secondary">{{ $article->title }}</a></h2>
                    <p class="blog-post-meta">{{ $article->created_at->diffForHumans() }}</p>
                </article>
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-light rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                </div>

                <div class="p-4">
                    <h4 class="fst-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
