@extends('themes.default.layout')
@section('title')
    {{ $tag->name }} - @parent
@endsection
@section('content')
    <div class="bg-light p-3 mb-1">
        <h4>标签：{{ $tag->name }}</h4>
    </div>
    <div class="row mt-2 mb-2">
        @foreach($posts as $post)
            <p>
                @if($post->type == \App\Constant\PostType::Article->value)
                    <a href="{{ route('articles.show', $post->slug) }}"
                       class="text-decoration-none link-secondary">{{ $post->title }}</a>
                @elseif($post->type == \App\Constant\PostType::Tweet->value)
                    <a href="{{ route('tweets.show', $post->slug) }}"
                       class="text-decoration-none link-secondary">{{ Str::limit($post->body, 20) }}</a>
                @endif
            </p>
        @endforeach
        {!! $posts->links() !!}
    </div>
@endsection
