@inject('tagPresenter','App\Presenters\TagPresenter')
@extends('layouts.app')
@section('description'){{ $post->post_excerpt }} @stop
@section('keywords'){{ $tagPresenter->showTags($post->tags) }}@stop
@section('author'){{ $post->user->name }}@stop
@section('title'){{ $post->post_title }} - @parent @stop
@section('css')
    <link href="https://cdn.bootcss.com/highlight.js/9.9.0/styles/default.min.css" rel="stylesheet">
@stop
@section('content')
    <section class="blog-post">
        @include('flash::message')
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="blog-post-meta">
                    <a href="{{ route('category.show',$post->category->category_slug) }}"><span class="label label-light label-primary">{{ $post->category->category_name }}</span></a>
                    @if($post->tags)
                        @foreach($post->tags as $tag)
                            <a href="{{ url('tag') }}/{{ $tag->tag_name }}"><span class="label label-light label-default">{{ $tag->tag_name }}</span></a>
                        @endforeach
                    @endif
                    <p class="blog-post-date pull-right">{{ $post->published_at }}</p>
                </div>
                <div class="blog-post-content">
                    <h2 class="blog-post-title">{{ $post->post_title }}</h2>
                    {!! $post->post_content_filter !!}
                    <p class="copy-right">
                        转载请注明出处：<a href="{{ $post->post_slug }}">{{ route('article.index',$post->post_slug ) }}</a>
                    </p>
                    <p class="bs-component btn-group-sm text-center">
                        @if($post->user->wechatpay || $post->user->alipay)
                        <a href="javascript:;" class="btn btn-danger btn-fab" id="btn-favorite"><i class="material-icons">赏</i></a>
                        @endif
                    </p>
                    <div class="text-center" id="favorite" hidden>
                        <p>“赏~”</p>
                        <ul class="list-unstyled">
                            @if($post->user->wechatpay)
                                <li>
                                    <img src='{{ asset($post->user->wechatpay) }}' >
                                    <p>微信支付</p>
                                </li>
                            @endif
                            @if($post->user->alipay)
                                <li>
                                    <img src='{{ asset($post->user->alipay) }}'>
                                    <p>支付宝</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('comment')
    @if($post->comment_status == 1)
        <section class="blog-comments">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="blog-post-title">评论</h2>
                    <ol id="comment_list" class="list-unstyled comment-list">
                        @if($comments)
                            @foreach($comments as $key => $comment)
                                <li id="comment-{{ $comment->id }}" class="anchor">
                                    <article class="row">
                                        <div class="col-sm-2 text-center">
                                            <img src="{{ $comment->comment_author_avatar ? asset('uploads/avatars').'/'.$comment->comment_author_avatar : asset('img/avatar.png') }}" alt="" class="avatar avatar-img-thumbnail-small">
                                        </div>
                                        <div class="col-sm-10">
                                            <p><a href="javascript:;" id="name">{{ $comment->comment_author }}</a>&nbsp;&nbsp;<i class="blog-post-date">{{$comment->created_at}}</i><span class="pull-right"><a href="javascript:void(0);">#{{ $key+1 }}</a></span></p>
                                            {!! $comment->comment_content_filter !!}
                                            <a class="reply btn btn-primary btn-raised btn-sm">回复</a>
                                        </div>
                                    </article>
                                </li>
                            @endforeach
                        @else
                            <li id="comment-{{ $comment->id }}" class="anchor">还没有评论哟！</li>
                        @endif
                    </ol>
                    <div id="comment_thread">
                        <form action="{{ route('comment.store') }}" method="post" class="form-horizontal">
                            <div class="form-group" id="reply_indicator">

                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            @if(Auth::check())
                                <input type="hidden" id="comment_author" name="comment_author" value="{{ Auth::user()->name }}">
                                <input type="hidden" id="comment_author_email" name="comment_author_email" value="{{ Auth::user()->email }}">
                                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            @else
                                <div class="form-group">
                                    <label for="comment_author" class="col-sm-2 control-label">名字 <sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="comment_author" name="comment_author" placeholder="昵称" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment_author_email" class="col-sm-2 control-label">邮箱 <sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="comment_author_email" name="comment_author_email" placeholder="邮箱地址" required>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="comment_content" class="col-sm-2 control-label">评论 <sup>*</sup></label>
                                <div class="col-sm-10">
                                    <textarea name="comment_content" id="comment_content" class="form-control" rows="4" placeholder="请输入评论内容,支持Markdown语法"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary btn-raised">提交评论</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@stop
@section('script')
    <script src="https://cdn.bootcss.com/highlight.js/9.9.0/highlight.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
        $(function () {
            $("[data-toggle='popover']").popover({
                html : true,
                trigger : 'hover',
                container: 'body',
                placement: 'auto top',
            });
            $("#btn-favorite").on('click',function () {
                $('#share').prop('hidden',true);
                if ($('#favorite').prop('hidden') == false){
                    $('#favorite').prop('hidden',true);
                }else {
                    $('#favorite').prop('hidden',false);
                }
            });
            $("#btn-share").on('click',function () {
                $('#favorite').prop('hidden',true);
                if ($('#share').prop('hidden') == false){
                    $('#share').prop('hidden',true);
                }else {
                    $('#share').prop('hidden',false);
                }
            });
            $(".reply").on('click',function () {
                var obj = $(this).parents('li');
                var _id = obj.attr('id');
                var _name = $(this).siblings('p').children('a').html();

                var _html = '<div class="alert alert-dismissible alert-success">'
                            +'<button type="button" class="close" id="dismiss">×</button>'
                            +'@ <a href="#'+_id+'"><strong>'+_name+'</strong></a>'
                            +'</div>'
                            +'<input type="hidden" name="comment_parent" value="'+(_id.split("-"))[1]+'">'
                            +'<input type="hidden" name="comment_parent_name" value="'+_name+'">';
                $("#reply_indicator").empty().append(_html);
                $("#comment_author").focus();
            });

            $("#reply_indicator").on('click','#dismiss',function () {
                var obj = $(this).parents("#reply_indicator");
                obj.empty();
            });
            $('#reply_indicator').on('click','a',function(){
                handler(this.hash)
            });
            var handler=function(hash){
                var target = document.getElementById(hash.slice(1));
                if (!target) return;
                var targetOffset = $(target).offset().top-60;
                $('html,body').animate({scrollTop: targetOffset}, 400);
            }

            $('a[href^=#][href!=#]').click(function(){
                handler(this.hash)
            });
            if(location.hash){ handler(location.hash) }
        });
    </script>
@stop