@extends('themes.default.layout')
@section('og_date'){{ $tweet->updated_at }}@endsection
@section('og_title'){{ $tweet->title }}@endsection
@section('og_description'){{ Str::limit($tweet->body,40) }}@endsection
@section('og_author'){{ $tweet->author->name ?? '' }}@endsection
@section('title'){{ Str::limit($tweet->body,40) }} &#8211;@endsection
@section('author'){{ $tweet->author->name ?? '' }}@endsection
@section('description'){{ Str::limit($tweet->body,50) }}@endsection
@section('content')
    <div class="row g-5">
        <div class="col-md-12">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <div class="mb-1 text-muted">
                        <a class="link-secondary"
                           href="{{ route('tweets.show', $tweet->id) }}#author"> {{ $tweet->author->name }}</a>
                        发布于 {{ $tweet->published_at->format('Y.m.d') }}
                        @if($tweet->published_at < $tweet->updated_at)
                            ，最后更新于 {{ $tweet->updated_at->format('Y.m.d') }}
                        @endif
                    </div>
                    <p class="card-text mb-auto">{!! $tweet->body !!}</p>
                    <div class="mt-1">
                        @foreach($tweet->tags as $tag)
                            <a href="{{ route('search.tags', $tag->slug) }}" class="link-secondary" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-hash" viewBox="0 0 16 16">
                                    <path
                                        d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                                </svg>{{ $tag->name }}</a>&nbsp;&nbsp;
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="author" class="row g-4 mt-2">
        <div class="col-md-12">
            <div class="p-4 mb-3 bg-light rounded">
                <div class="" style="display: flex">
                    <div class="avatar">
                        <img class="avatar-rounded img-fluid"
                             src="{{ $tweet->author->avatar ? Storage::disk('public')->url($tweet->author->avatar) : Avatar::create($tweet->author->name)->setBackground('#adb5bd')->toBase64() }}"
                             alt="">
                    </div>
                    <div style="margin: 0 12px;">
                        <p class="fs-2">{{ $tweet->author->name }}</p>
                        <p class="text-muted">{{ $tweet->author->bio ?: '暂无个人简介' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($tweet->commentable == \App\Constant\Commentable::Open->value)
        @include('themes.default.comment', ['model' => $tweet])
    @endif
@endsection
