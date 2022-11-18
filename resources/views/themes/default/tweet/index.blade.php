@extends('themes.default.layout')
@section('title')
    微博 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        @foreach($tweets as $tweet)
            <div class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <div class="mb-1 text-muted">
                            {{ $tweet->author->name }} 发布于 {{ $tweet->created_at->format('Y.m.d') }}
                        </div>
                        <p class="card-text mb-auto">{{ Str::limit($tweet->body) }}</p>
                        <a href="{{ route('tweets.show', $tweet->slug) }}" class="link-secondary text-sm">继续阅读 →</a>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $tweets->links() }}
    </div>
@endsection
