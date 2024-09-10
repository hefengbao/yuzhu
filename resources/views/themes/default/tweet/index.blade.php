@extends('themes.default.layout')
@section('title')微博 &#8211;@endsection
@section('content')
@php
    $groups = $tweets->groupBy(function ($item){
        return $item->published_at->format('Y');
    });
@endphp
@foreach($groups as $key => $group)
    <h4>{{ $key }}</h4>
    @foreach($group as $tweet)
        <article>
            <p><small>{{ $tweet->author->name }} 发布于 {{ $tweet->published_at->format('m月d日') }}</small></p>
            {!! \Illuminate\Support\Str::markdown($tweet->body) !!}
            <a href="{{ route('tweets.show', $tweet->slug_id) }}" target="_blank"><small>继续阅读 →</small></a>
        </article>
    @endforeach
@endforeach
{{ $tweets->links() }}
@endsection
