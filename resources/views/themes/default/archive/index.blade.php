@extends('themes.default.layout')
@section('title')归档 &#8211;@endsection
@section('content')
    <div class="row mb-2">
        @php
            $groups = $posts->groupBy(function ($item){
                return $item->published_at->format('Y');
            });
        @endphp
        @foreach($groups as $key => $group)
            <h3>{{ $key }}</h3>
            <div class="mb-2 mt-2">
                @foreach($group as $post)
                    <p>
                        <span class="fst-italic">{{ $post->published_at->format('m.d') }}&nbsp;&nbsp;</span>
                        <a href="@if($post->type == \App\Constant\PostType::Article->value){{ route('articles.show', $post->slug) }}@elseif($post->type == \App\Constant\PostType::Tweet->value){{ route('tweets.show', $post->slug) }}@elseif($post->type == \App\Constant\PostType::Page->value){{ route('pages.show', $post->slug) }}@endif" class="link-secondary">
                            {{ $post->title ?: Str::limit($post->body, 40) }}
                        </a>
                    </p>
                @endforeach
            </div>
        @endforeach
        {{ $posts->links() }}
    </div>
@endsection
