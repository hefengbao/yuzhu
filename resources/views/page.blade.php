@inject('tagPresenter','App\Presenters\TagPresenter')
@extends('layouts.app')
@section('description'){{ $page->post_excerpt }} @stop
@section('keywords')@parent @stop
@section('author')@parent @stop
@section('title'){{ $page->post_title }} - @parent @stop
@section('content')
    <section class="blog-post">
        <div class="panel panel-default">
            <img src="" class="img-responsive" />
            <div class="panel-body">
                <div class="blog-post-content">
                    <h2 class="blog-post-title">{{ $page->post_title }}</h2>
                    <div class="content">{!! $page->post_content_filter !!}</div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('comment')
    @if($page->comment_status == 1)
        <section class="blog-comments">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="blog-post-title">Comments</h2>
                    <div id="disqus_thread"></div>
                </div>
            </div>
        </section>
    @endif
@stop