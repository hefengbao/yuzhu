@extends('themes.default.layout')
@section('title')
    文章 &#8211;
@endsection
@section('content')
    @if($pinnedArticles->isNotEmpty())
        <h4>[置顶]</h4>
        <div class="mb-2 mt-2">
            @foreach($pinnedArticles as $article)
                <p>
                    <span class="fst-italic text-secondary">{{ $article->published_at->format('Y年m月d日') }}&nbsp;&nbsp;</span>
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
        <h4>{{ $key }}</h4>
        <ul>
            @foreach($group as $article)
                <li>
                    <p>
                        <small>{{ $article->published_at->format('m月d日') }}</small> »
                        <a href="{{ route('articles.show', $article->slug_id) }}">{{ $article->title }}</a>
                    </p>
                </li>
            @endforeach
        </ul>
    @endforeach
    {{ $articles->links() }}
@endsection
