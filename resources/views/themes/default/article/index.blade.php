@extends('themes.default.layout')
@section('title')
    文章 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        @if($pinnedArticles->isNotEmpty())
            <h3>[置顶]</h3>
            <div class="mb-2 mt-2">
                @foreach($pinnedArticles as $article)
                    <p>
                        <span class="fst-italic text-secondary">{{ $article->published_at->format('Y.m.d') }}&nbsp;&nbsp;</span>
                        <a href="{{ route('articles.show', $article->slug_id) }}" class="link-dark" target="_blank">
                            {{ $article->title }}
                        </a>
                    </p>
                @endforeach
            </div>
        @endif
        @php
            $groups = $articles->groupBy(function ($item){
                return $item->published_at->format('Y');
            });
        @endphp
        @foreach($groups as $key => $group)
            <h3>{{ $key }}</h3>
            <div class="mb-2 mt-2">
                @foreach($group as $article)
                    <p>
                        <span
                            class="fst-italic text-secondary">{{ $article->published_at->format('m.d') }}&nbsp;&nbsp;</span>
                        <a href="{{ route('articles.show', $article->slug_id) }}" class="link-dark" target="_blank">
                            {{ $article->title }}
                        </a>
                    </p>
                @endforeach
            </div>
        @endforeach
        {{ $articles->links() }}
    </div>
@endsection
