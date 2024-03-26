@extends('admin.layouts.app')
@section('title')
    评论 - @parent
@endsection
@section('header')
    评论列表
@endsection
@section('content')
    <div class="row p-2">
        <div class="sub col-md-12">
            <a href="{{ route('admin.comments.index') }}"
               class="bg-aqua-active"><span>全部 ({{ $metrics['total'] }})</span></a>
            @if($metrics['my_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.comments.index') }}?author={{ auth()->id() }}"><span>我的 ({{ $metrics['my_total'] }})</span></a>
            @endif
            @if($metrics['pending_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.comments.index') }}?status=pending"><span>待审 ({{ $metrics['pending_total'] }})</span></a>
            @endif
            @if($metrics['approved_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.comments.index') }}?status=approved"><span>已批准 ({{ $metrics['approved_total'] }})</span></a>
            @endif
            @if($metrics['spam_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.comments.index') }}?status=spam"><span>垃圾评论 ({{ $metrics['spam_total'] }})</span></a>
            @endif
            @if($metrics['trash_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.comments.index') }}?status=trash"><span>回收站 ({{ $metrics['trash_total'] }})</span></a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>作者</th>
                        <th>评论</th>
                        <th>回复至</th>
                        <th>日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>
                                @if($comment->user_id)
                                    {{ $comment->author->name }}
                                    @if($authUser->isAdministrator())
                                        <span class="badge badge-primary">管理员</span>
                                    @elseif($authUser->isEditor())
                                        <span class="badge badge-primary">编辑</span>
                                    @elseif($authUser->isAuthor())
                                        <span class="badge badge-primary">作家</span>
                                    @endif<br>
                                    {{ $comment->author->email }}<br>
                                @else
                                    {{ $comment->guest_name }}<span class="badge badge-info">游客</span><br>
                                    {{ $comment->guest_email }}<br>
                                @endif
                                {{ $comment->ip }}
                            </td>
                            <td>
                                {!! \Illuminate\Support\Facades\App::make(\App\One\MarkdownToHtml::class)->convert($comment->body) !!}
                                @if($comment->status == \App\Constant\CommentStatus::Pending->value)
                                    <a href="#" id="approve" data-id="{{ $comment->id }}">
                                        <span class="text-muted text-sm">批准</span>
                                    </a>
                                    <form class="d-none" id="form-approve-{{ $comment->id }}"
                                          action="{{ route('admin.comments.approve', $comment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                                @if($comment->status == \App\Constant\CommentStatus::Approved->value)
                                    @if($post = $comment->post)
                                        @if($post->type == \App\Constant\PostType::Article->value)
                                            <a href="{{ route('articles.show', $post->slug) }}#comment-{{ $comment->id }}"
                                               class="text-muted text-sm" target="_blank">回复</a>
                                        @elseif($post->type == \App\Constant\PostType::Page->value)
                                            <a href="{{ route('pages.show', $post->slug) }}#comment-{{ $comment->id }}"
                                               class="text-muted text-sm" target="_blank">回复</a>
                                        @elseif($post->type == \App\Constant\PostType::Tweet->value)
                                            <a href="{{ route('tweets.show', $post->slug) }}#comment-{{ $comment->id }}"
                                               class="text-muted text-sm" target="_blank">回复</a>
                                        @endif
                                    @endif
                                    <a href="#" id="pending" data-id="{{ $comment->id }}">
                                        <span class="text-muted text-sm">驳回</span>
                                    </a>
                                    <form class="d-none" id="form-pending-{{ $comment->id }}"
                                          action="{{ route('admin.comments.pending', $comment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                                @if($comment->status == \App\Constant\CommentStatus::Spam->value || $comment->status == \App\Constant\CommentStatus::Trash->value)
                                    <a href="#" id="restore" data-id="{{ $comment->id }}">
                                        <span class="text-muted text-sm">还原</span>
                                    </a>
                                    <form class="d-none" id="form-restore-{{ $comment->id }}"
                                          action="{{ route('admin.comments.restore', $comment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                                @if($comment->status == \App\Constant\CommentStatus::Approved->value || $comment->status == \App\Constant\CommentStatus::Pending->value)
                                    <a href="#" id="spam" data-id="{{ $comment->id }}">
                                        <span class="text-danger text-sm">标记为垃圾</span>
                                    </a>
                                    <form class="d-none" id="form-spam-{{ $comment->id }}"
                                          action="{{ route('admin.comments.spam', $comment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                    <a href="#" id="trash" data-id="{{ $comment->id }}">
                                        <span class="text-danger text-sm">移至回收站</span>
                                    </a>
                                    <form class="d-none" id="form-trash-{{ $comment->id }}"
                                          action="{{ route('admin.comments.trash', $comment->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if($post = $comment->post)
                                    @if($post->type == \App\Constant\PostType::Article->value)
                                        <a href="{{ route('articles.show', $post->slug_id) }}"
                                           title="{{ $post->title }}"
                                           target="_blank">查看文章</a>
                                    @elseif($post->type == \App\Constant\PostType::Page->value)
                                        <a href="{{ route('pages.show', $post->slug_id) }}" title="{{ $post->title }}"
                                           target="_blank">查看页面</a>
                                    @elseif($post->type == \App\Constant\PostType::Tweet->value)
                                        <a href="{{ route('tweets.show', $post->slug_id) }}"
                                           title="{{ Str::limit($post->body,20) }}" target="_blank">查看微博</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($comment->status == \App\Constant\CommentStatus::Approved->value)
                                    <span class="badge badge-primary">已批准</span>
                                @elseif($comment->status == \App\Constant\CommentStatus::Pending->value)
                                    <span class="badge badge-info">待审核</span>
                                @elseif($comment->status == \App\Constant\CommentStatus::Spam->value)
                                    <span class="badge badge-danger">垃圾评论</span>
                                @elseif($comment->status == \App\Constant\CommentStatus::Trash->value)
                                    <span class="badge badge-secondary">回收站</span>
                                @endif<br>
                                {{ $comment->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("a#pending").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认驳回?',
                    text: "被驳回的评论可在待审列表查看",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-pending-' + id).submit()
                    }
                })
            });

            $("a#approve").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认批准？',
                    text: '批准的评论会显示在文章等的评论区',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-approve-' + id).submit()
                    }
                })
            });

            $("a#spam").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认标记为垃圾吗？',
                    text: '标记后的评论在垃圾评论列表查看',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-spam-' + id).submit()
                    }
                })
            });

            $("a#trash").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认移至回收站吗？',
                    text: '可在回收站查看',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-trash-' + id).submit()
                    }
                })
            });

            $("a#restore").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认还原吗？',
                    text: '还原后可在待审列表查看',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-restore-' + id).submit()
                    }
                })
            });
        });
    </script>
@endsection
