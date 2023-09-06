@extends('admin.layouts.app')
@section('title')
    微博列表 - @parent
@endsection
@section('header')
    微博列表 <a href="{{ route('admin.tweets.create') }}" class="btn btn-outline-primary btn-sm">写微博</a>
@endsection
@section('content')
    <div class="row p-2">
        <div class="sub col-md-12">
            <a href="{{ route('admin.tweets.index') }}"
               class="bg-aqua-active"><span>全部 ({{ $metrics['total'] }})</span></a>
            @roles(['administrator','editor'])
            @if($metrics['my_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.tweets.index') }}?author={{auth()->id() }}"><span>我的 ({{ $metrics['my_total'] }})</span></a>
            @endif
            @endroles
            @if($metrics['publish_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.tweets.index') }}?status=publish"><span>已发布 ({{ $metrics['publish_total'] }})</span></a>
            @endif
            @if($metrics['trash_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.tweets.index') }}?status=trash"><span>回收站 ({{ $metrics['trash_total'] }})</span></a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>内容</th>
                        <th>作者</th>
                        <th>标签</th>
                        <th>评论</th>
                        <th>日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tweets as $tweet)
                        <tr>
                            <td>
                                <a href="{{ route('tweets.show', $tweet->slug_id) }}" target="_blank">{{ Str::limit($tweet->body, 50) }}<br></a>
                                <a href="{{ route('admin.tweets.edit', $tweet->id) }}">
                                    <span class="text-muted text-sm">编辑</span>
                                </a>
                                @if($tweet->status != \App\Constant\PostStatus::Trash->value)
                                    &nbsp;|&nbsp;
                                    <a href="#" id="delete" data-id="{{ $tweet->id }}">
                                        <span class="text-danger text-sm">移至回收站</span>
                                    </a>
                                    <form class="d-none" id="form-trash-{{ $tweet->id }}"
                                          action="{{ route('admin.tweets.destroy', $tweet->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endif
                            </td>
                            <td class="text-sm">
                                @roles(['administrator', 'editor'])
                                <a href="{{ route('admin.tweets.index') }}?author={{ $tweet->author->id }}">{{ $tweet->author->name }}</a>
                                @else
                                    {{ $tweet->author->name }}
                                    @endroles
                            </td>
                            <td class="text-sm">
                                @if($tweet->tags->isNotEmpty())
                                    {!! tags_to_str($tweet->tags) !!}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($tweet->comments_count)
                                    <a href="{{ route('tweets.show', $tweet->id) }}#comments" target="_blank"><i
                                            class="fas fa-comments"></i> {{ $tweet->comments_count }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($tweet->status == \App\Constant\PostStatus::Publish->value)
                                    已发布<br>{{ $tweet->published_at }}
                                @elseif($tweet->status == \App\Constant\PostStatus::Draft->value)
                                    草稿,最后修改<br>{{ $tweet->meta->updated_at }}
                                @elseif($tweet->status == \App\Constant\PostStatus::Future->value)
                                    定时发布<br>{{ $tweet->meta->published_at }}
                                @elseif($tweet->status == \App\Constant\PostStatus::Pending->value)
                                    待审核,最后修改<br>{{ $tweet->updated_at }}
                                @elseif($tweet->status == \App\Constant\PostStatus::Trash->value)
                                    回收站,最后修改<br>{{ $tweet->updated_at }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $tweets->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("a#delete").on('click', function (e, element) {
                e.preventDefault()
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认删除?',
                    text: "您即将从您的站点永久删除数据!此操作不能撤销!",
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
        });
    </script>
@endsection
