@extends('layouts.app')
@section('description')@parent @stop
@section('keywords')@parent @stop
@section('author')@parent @stop
@section('title')归档 - @parent @stop
@section('content')
    <section class="blog-post">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="blog-post-meta">
                    归档
                </div>
                <div class="blog-post-content">
                    <ol class="list-unstyled">
                        @foreach($datas as $data)
                            <li>
                                {{ $data->published_at->toDateString()}}&nbsp;&nbsp; &raquo; &nbsp;&nbsp;<a
                                        href="{{ url('/article') }}/{{ $data->post_slug }}"><span>{{ $data->post_title }}</span></a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section><!-- /.blog-post -->
@stop
