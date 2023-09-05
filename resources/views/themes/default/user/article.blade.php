@extends('themes.default.layout')
@section('title')
    文章 &#8211;
@endsection
@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="p-4 mb-3 bg-light rounded">
                <div class="" style="display: flex">
                    <div class="avatar">
                        <img class="avatar-rounded img-fluid"
                             src="{{ $user->avatar ? Storage::disk('public')->url($user->avatar) : Avatar::create($user->name)->setBackground('#adb5bd')->toBase64() }}"
                             alt="">
                    </div>
                    <div style="margin: 0 12px;">
                        <p class="fs-2">{{ $user->name }}</p>
                        <p class="text-muted">{{ $user->bio ?: '暂无个人简介' }}</p>
                    </div>
                </div>
            </div>
        </div>
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
                        <span class="fst-italic text-secondary">{{ $article->published_at->format('m.d') }}&nbsp;&nbsp;</span>
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
