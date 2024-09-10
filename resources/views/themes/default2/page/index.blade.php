@extends('themes.default.layout')
@section('title')
    页面 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        <div class="mb-2 mt-2">
            @foreach($pages as $page)
                <p>
                        <span
                            class="fst-italic text-secondary">{{ $page->published_at->format('Y.m.d') }}&nbsp;&nbsp;</span>
                    <a href="{{ route('pages.show', $page->slug_id) }}" class="link-dark" target="_blank">
                        {{ $page->title }}
                    </a>
                </p>
            @endforeach
        </div>
    </div>
@endsection
