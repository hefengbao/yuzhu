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
                                    <i class="fas fa-newspaper"></i> {{ $data['metrics']['article_count'] }} 篇文章
                                </td>
                                <td>
                                    <i class="fas fa-blog"></i> {{ $data['metrics']['tweet_count'] }} 条微博
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-file-alt"></i> {{ $data['metrics']['page_count'] }} 个页面
                                </td>
                                <td>
                                    <i class="fas fa-comments"></i> {{ $data['metrics']['comment_count'] }} 条评论
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
                                    {!! \Illuminate\Support\Facades\App::make(\App\One\MarkdownToHtml::class)->convert($comment->body) !!}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
