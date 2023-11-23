@php
    $comments = $model->comments()->with(['parent','author'])->where('status', \App\Constant\CommentStatus::Approved->value)->orderBy('created_at')->get();
@endphp
@section('style')
    <style rel="stylesheet">
        .comment-reply-title :where(small) {
            font-size: var(--bs-body-font-size);
        }
    </style>
@endsection
<div id="comments" class="row g-5 mt-2">
    <div class="col-md-12">
        <h3>有{{ $comments->count() }}条评论</h3>
        <ol class="list-unstyled mt-4 list-group list-group-flush">
            @foreach($comments as $comment)
                <li id="comment-{{ $comment->id }}" class="list-group-item p-2">
                    <article>
                        <div class="d-flex flex-row">
                            <img class="avatar-rounded img-fluid avatar"
                                 src="@if($comment->author) @if($comment->author->avatar) {{ Storage::disk('public')->url($comment->author->avatar)  }} @else {{ Avatar::create($comment->author->name)->setBackground('#adb5bd')->toBase64() }} @endif @else {{ Avatar::create($comment->guest_name)->setBackground('#adb5bd')->toBase64() }} @endif"
                                 alt="">
                            <div class="d-flex flex-column px-2">
                                <div class="mb-0">@if($comment->author)
                                        <span style="font-size: larger">{{ $comment->author->name }}</span>
                                        @if($comment->author->isAdministrator())
                                            <span class="bg-secondary badge badge-info"
                                                  style="font-size: 0.5rem">管理员</span>
                                        @elseif($comment->author->isEditor())
                                            <span class="bg-secondary badge badge-info"
                                                  style="font-size: 0.5rem">编辑</span>
                                        @else
                                            <span class="bg-secondary badge badge-info"
                                                  style="font-size: 0.5rem">作家</span>
                                        @endif
                                    @else
                                        {{ $comment->guest_name }}
                                        <span class="bg-secondary badge badge-info"
                                              style="font-size: 0.5rem">游客</span>
                                    @endif
                                </div>
                                <p class="text-muted mb-0"><small>{{ $comment->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                        <div style="margin-left: 3.5rem;">
                            @if($comment->parent && $comment->parent->status == \App\Constant\CommentStatus::Approved->value)
                                <div id="reply-to" class="bg-light p-2 mt-2">
                                    <p>
                                        <a class="link-secondary" href="{{ url()->current() }}#comment-{{ $comment->parent->id }}">{{ '@' }}{{ $comment->parent->author ? $comment->parent->author->name : $comment->parent->guest_name }}</a>
                                    </p>
                                    {!! \Illuminate\Support\Facades\App::make(\App\One\MarkdownToHtml::class)->convert($comment->parent->body) !!}
                                </div>
                            @endif
                            <div id="comment-body" class="mt-2">
                                {!! \Illuminate\Support\Facades\App::make(\App\One\MarkdownToHtml::class)->convert($comment->body) !!}
                            </div>
                            <a href="{{ url()->current() }}#respond" rel="nofollow" class="reply-link link-secondary"
                               data-postid="{{ $model->id }}"
                               onclick="reply({{ $comment->id }},'{{ $comment->author ? $comment->author->name : $comment->guest_name }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-reply" viewBox="0 0 16 16">
                                    <path
                                        d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                                </svg>
                                回复</a>
                        </div>
                    </article>
                </li>
            @endforeach
        </ol>
    </div>
</div>
<div id="respond" class="col-md-12 mt-4 mb-4">
    <h3 id="reply-title" class="comment-reply-title">发表评论</h3>
    <p>@auth
            <a class="link-secondary"
               href="{{ route('admin.users.edit', auth()->id()) }}">已登录为{{ auth()->user()->name }}</a> <a
                class="link-secondary" href="#">注销？</a>
        @endauth @guest
            您的电子邮箱地址不会被公开。
        @endguest 必填项已用 * 标注</p>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form id="comment-form" action="{{ route('comments.store', $model->slug_id) }}" method="POST">
        @csrf
        <input type="hidden" name="parent" id="parent">
        <div class="mb-3">
            <label for="editor" class="form-label">评论*</label>
            <textarea id="editor" name="body" class="form-control">{{ old('body') }}</textarea>
        </div>
        @guest
            <div class="mb-3">
                <label for="name" class="form-label">显示名称*</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">电子邮箱*</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
        @endguest
        <button id="submit" type="submit" class="btn btn-dark">发表评论</button>
    </form>
</div>
@include('themes.default.markdown_editor')
<script type="text/javascript">
    let replyTitle = document.getElementById('reply-title')
    let parent = document.getElementById('parent')

    function reply(commentId, commentAuthor) {
        replyTitle.innerHTML = "回复<a class='link-secondary' href='{{ url()->current() }}#comment-"
            + commentId
            + "'>"
            + commentAuthor
            + "</a>&nbsp;&nbsp;<small><a class='link-secondary' href='{{ url()->current() }}#respond' onclick='cancelReply()'>取消回复<small>"

        parent.value = commentId
    }

    function cancelReply() {
        parent.value = null
        replyTitle.innerHTML = '发表评论'
    }
</script>
