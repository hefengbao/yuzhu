@extends('themes.default.layout')
@section('title')
    微博 &#8211;
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
            $groups = $tweets->groupBy(function ($item){
                return $item->published_at->format('Y');
            });
        @endphp
        @foreach($groups as $key => $group)
            <h3>{{ $key }}</h3>
            @foreach($group as $tweet)
                <div class="col-md-6">
                    <div
                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <div class="mb-1 text-muted">
                                {{ $user->name }} 发布于 {{ $tweet->created_at->format('m.d') }}
                            </div>
                            <p class="card-text mb-auto">{{ Str::limit($tweet->body)}}</p>
                            <a href="{{ route('tweets.show', $tweet->slug_id) }}" class="link-secondary">继续阅读 →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
        {{ $tweets->links() }}
    </div>
@endsection
