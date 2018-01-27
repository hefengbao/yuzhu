@extends('layouts.app')
@section('description')@parent @stop
@section('keywords')@parent @stop
@section('author')@parent @stop
@section('title'){{$query}}-搜索结果 @parent @stop
@section('content')
    <div class="search-results">
        <section class="blog-post">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="blog-post-content">
                        <p><i class="fa fa-search"></i> 关于<b> “{{ $query }}”</b> 的搜索结果, 共 {{ $posts->total() }} 条</p>
                    </div>
                </div>
            </div>
        </section>
        @foreach($posts as $post)
            <section class="blog-post">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <a href="{{ route('category.show',$post->category->category_slug) }}"><span
                                        class="label label-light label-primary">{{ $post->category->category_name }}</span></a>
                            @if($post->tags)
                                @foreach($post->tags as $tag)
                                    <a href="{{ url('tag') }}/{{ $tag->tag_name }}"><span
                                                class="label label-light label-default">{{ $tag->tag_name }}</span></a>
                                @endforeach
                            @endif
                            <p class="blog-post-date pull-right">{{ $post->published_at }}</p>
                        </div>
                        <div class="blog-post-content">
                            <a href="{{ url('/article') }}/{{ $post->post_slug }}"><h2
                                        class="blog-post-title">{{ $post->post_title }}</h2></a>
                            <p>{{ $post->post_excerpt }}</p>
                            <a class="btn btn-info" href="{{ url('/article') }}/{{ $post->post_slug }}">Read more</a>
                        </div>
                    </div>
                </div>
            </section><!-- /.blog-post -->
        @endforeach
    </div>
    {!! $posts->links() !!}
@stop
@section('script')
    <script>
        $(document).ready(function () {
            var query = '{{ $query }}';
            var results = query.match(/("[^"]+"|[^"\s]+)/g);
            results.forEach(function (entry) {
                $('.search-results').highlight(entry);
            });
        });
    </script>
@stop
