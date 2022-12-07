@extends('admin.layouts.app')
@section('title')
    仪表盘 - @parent
@endsection
@section('header')
    仪表盘
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">概览</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <svg class="svg-inline--fa fa-newspaper nav-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="newspaper" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M96 96c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H80c-44.2 0-80-35.8-80-80V128c0-17.7 14.3-32 32-32s32 14.3 32 32V400c0 8.8 7.2 16 16 16s16-7.2 16-16V96zm64 24v80c0 13.3 10.7 24 24 24H424c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm0 184c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm160 0c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H336c-8.8 0-16 7.2-16 16zM160 400c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm160 0c0 8.8 7.2 16 16 16h96c8.8 0 16-7.2 16-16s-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"></path>
                                    </svg> {{ $data['metrics']['article_count'] }} 篇文章
                                </td>
                                <td>
                                    <svg class="svg-inline--fa fa-blog nav-icon" aria-hidden="true" focusable="false"
                                         data-prefix="fas" data-icon="blog" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M192 32c0 17.7 14.3 32 32 32c123.7 0 224 100.3 224 224c0 17.7 14.3 32 32 32s32-14.3 32-32C512 128.9 383.1 0 224 0c-17.7 0-32 14.3-32 32zm0 96c0 17.7 14.3 32 32 32c70.7 0 128 57.3 128 128c0 17.7 14.3 32 32 32s32-14.3 32-32c0-106-86-192-192-192c-17.7 0-32 14.3-32 32zM96 144c0-26.5-21.5-48-48-48S0 117.5 0 144V368c0 79.5 64.5 144 144 144s144-64.5 144-144s-64.5-144-144-144H128v96h16c26.5 0 48 21.5 48 48s-21.5 48-48 48s-48-21.5-48-48V144z"></path>
                                    </svg> {{ $data['metrics']['tweet_count'] }} 条微博
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <svg class="svg-inline--fa fa-file-lines nav-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="file-lines" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path>
                                    </svg> {{ $data['metrics']['page_count'] }} 个页面
                                </td>
                                <td>
                                    <svg class="svg-inline--fa fa-comments nav-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="comments" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"></path>
                                    </svg> {{ $data['metrics']['comment_count'] }} 条评论
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">动态</div>
                <div class="card-body">
                    <p>最近发布:</p>
                    <ou class="list-unstyled">
                        @foreach($data['trend']['posts'] as $post)
                            <li>
                                <p>
                                    <span class="text-muted">{{ $post->created_at->format('m月d日 H时i分') }}</span>&nbsp;&nbsp;
                                    @if($post->type == \App\Constant\PostType::Article->value)
                                        <a href="{{ route('articles.show', $post->id) }}"
                                           target="_blank">{{ $post->title }}</a>
                                    @elseif($post->type == \App\Constant\PostType::Tweet->value)
                                        <a href="{{ route('tweets.show', $post->id) }}"
                                           target="_blank">{{ Str::limit($post->body,40) }}</a>
                                    @elseif($post->type == \App\Constant\PostType::Page->value)
                                        <a href="{{ route('pages.show', $post->id) }}"
                                           target="_blank">{{ $post->title }}</a>
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    </ou>
                    <p>最近评论:</p>
                    <ul class="list-unstyled">
                        @foreach($data['trend']['comments'] as $comment)
                            <li class="border-bottom pt-1">
                            <span class="text-muted">
                                由@if($comment->author)
                                    {{ $comment->author->name }}
                                @else
                                    {{ $comment->guest_name }}
                                @endif发表在《@if($comment->post->type == \App\Constant\PostType::Article->value)
                                    <a href="{{ route('articles.show', $comment->post->id) }}#comment-{{ $comment->id }}"
                                       target="_blank">{{ $comment->post->title }}</a>
                                @elseif($comment->post->type == \App\Constant\PostType::Tweet->value)
                                    <a href="{{ route('tweets.show', $comment->post->id) }}#comment-{{ $comment->id }}"
                                       target="_blank">{{ Str::limit($comment->post->body,40) }}</a>
                                @elseif($comment->post->type == \App\Constant\PostType::Page->value)
                                    <a href="{{ route('pages.show', $comment->post->id) }}#comment-{{ $comment->id }}"
                                       target="_blank">{{ $comment->post->title }}</a>
                                @endif
                                》@if($comment->status ==\App\Constant\CommentStatus::Pending->value)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-flag-fill" viewBox="0 0 16 16">
  <path
      d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
</svg>[待审]
                                @endif
                            </span>
                                <div>
                                    {!! \App\One\EditorJs\Facades\LaravelEditorJs::render($comment->body) !!}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
