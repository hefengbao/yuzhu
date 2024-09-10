@extends('themes.default.layout')
@section('og_date'){{ $article->updated_at }}@endsection
@section('og_title'){{ $article->title }}@endsection
@section('og_description'){{ $article->excerpt ?? '' }}@endsection
@section('og_author'){{ $article->author->name ?? '' }}@endsection
@section('title'){{ $article->title }} &#8211;@endsection
@section('author'){{ $article->author->name ?? '' }}@endsection
@section('description'){{ $article->excerpt ?? '' }}@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('libs/prism/prism.css') }}">
@endsection
@section('content')
<section>
    <!--标题-->
    <hgroup>
        <h1>{{ $article->title }}</h1>
        <p>
            {{ $article->author->name }}
            @if($article->published_at)
                发布于 {{ $article->published_at->format('Y.m.d') ?? $article->creatd_at->format('Y.m.d') }}
                @if( $article->published_at < $article->updated_at)
                    ，最后更新于 {{ $article->updated_at->format('Y.m.d') }}
                @endif
            @endif
        </p>
    </hgroup>

    <!--内容-->
    {!! \Illuminate\Support\Str::markdown($article->body) !!}

    <!--分类、标签-->
    @if($article->categories->isNotEmpty() || $article->tags->isNotEmpty())
        <p>
            @if($article->categories->isNotEmpty())
                @foreach($article->categories as $category)
                    <a href="{{ route('search.categories', $category->slug) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-tag" viewBox="0 0 16 16">
                            <path
                                d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z"/>
                            <path
                                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z"/>
                        </svg>{{ $category->name }}
                    </a>
                    &nbsp;&nbsp;
                @endforeach
            @endif
            @if($article->tags->isNotEmpty())
                @foreach($article->tags as $tag)
                    <a href="{{ route('search.tags', $tag->slug) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-hash" viewBox="0 0 16 16">
                            <path
                                d="M8.39 12.648a1.32 1.32 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 0 0-.523-.516.539.539 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"/>
                        </svg>{{ $tag->name }}</a>&nbsp;&nbsp;
                @endforeach
            @endif
        </p>
    @endif

    <!--内容导航-->
    <div  style="padding:1.5rem 0">
        @if($prev)
            <p>
                <a class="link-secondary"
                   href="{{ route('articles.show', $prev->slug_id) }}">上一篇：{{ $prev->title }}</a>
            </p>
        @endif
        @if($next)
            <p>
                <a class="link-secondary"
                   href="{{ route('articles.show', $next->slug_id) }}">下一篇：{{ $next->title }}</a>
            </p>
        @endif
    </div>
</section>

<!--评论-->
@if($article->commentable = \App\Constant\Commentable::Open)
    <section>
        @include('themes.default.comment', ['model' => $article])
    </section>
@endif
@endsection
@section('script')
<script src="{{ asset('libs/prism/prism.js') }}"></script>
@endsection
