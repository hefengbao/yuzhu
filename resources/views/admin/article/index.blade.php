@extends('admin.layouts.app')

@section('title')文章列表 - @parent @endsection

@section('header')
    文章列表 <a href="{{ route('admin.articles.create') }}" class="btn btn-outline-primary btn-sm">写文章</a>
@endsection

@section('content')
    <div class="row p-2">
        <div class="sub col-md-12">
            <a href="{{ route('admin.articles.index') }}"
               class="bg-aqua-active"><span>全部 ({{ $metrics['total'] }})</span></a>
            @roles(['administrator','editor'])
            @if($metrics['my_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?author={{ auth()->id() }}"><span>我的 ({{ $metrics['my_total'] }})</span></a>
            @endif
            @endroles
            @if($metrics['publish_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?status=publish"><span>已发布 ({{ $metrics['publish_total'] }})</span></a>
            @endif
            @if($metrics['future_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?status=future"><span>定时发布 ({{ $metrics['future_total'] }})</span></a>
            @endif
            @if($metrics['pin_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?pin=true"><span>置顶 ({{ $metrics['pin_total'] }})</span></a>
            @endif
            @if($metrics['pending_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?status=pending"><span>待审 ({{ $metrics['pending_total'] }})</span></a>
            @endif
            @if($metrics['draft_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?status=draft"><span>草稿 ({{ $metrics['draft_total'] }})</span></a>
            @endif
            @if($metrics['trash_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.articles.index') }}?status=trash"><span>回收站 ({{ $metrics['trash_total'] }})</span></a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-4">标题</th>
                        <th class="col-1">作者</th>
                        <th class="col-2">分类</th>
                        <th class="col-2">标签</th>
                        <th class="col-1">评论</th>
                        <th class="col-2">日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>
                                <a href="{{ route('articles.show', $article->slug_id) }}" target="_blank">
                                    {{ $article->title }}
                                </a>
                                <div class="row pl-2">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}">
                                        <span class="text-muted text-sm">编辑</span>
                                    </a>
                                    @if($article->status == \App\Constant\PostStatus::Publish->value)
                                        @roles(['administrator','editor'])
                                        &nbsp;|&nbsp;
                                        <a href="#" id="pin" data-id="{{ $article->id }}">
                                            <span class="text-danger text-sm">
                                                @if($article->pinned_at)
                                                    取消置顶
                                                @else
                                                    置顶
                                                @endif
                                            </span>
                                        </a>
                                        <form class="d-none" id="form-pin-{{ $article->id }}"
                                              action="{{ route('admin.articles.pin', $article->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        @endroles
                                    @endif
                                    @if($article->status != \App\Constant\PostStatus::Trash->value)
                                        &nbsp;|&nbsp;
                                        <a href="#" id="delete" data-id="{{ $article->id  }}">
                                            <span class="text-danger text-sm">移至回收站</span>
                                        </a>
                                        <form class="d-none" id="form-trash-{{ $article->id }}"
                                              action="{{ route('admin.articles.destroy', $article->id) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <td class="text-sm">
                                @roles(['administrator','editor'])
                                <a href="{{ route('admin.articles.index') }}?author={{ $article->author->id }}">
                                    {{ $article->author->name }}</a>
                                @else
                                    {{ $article->author->name }}
                                    @endroles
                            </td>
                            <td class="text-sm">
                                @if($article->categories->isNotEmpty())
                                    {!! categories_to_str($article->categories) !!}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($article->tags->isNotEmpty())
                                    {!! tags_to_str($article->tags) !!}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($article->comments_count)
                                    <a href="{{ route('articles.show', $article->slug_id) }}#comments" target="_blank"><i
                                            class="fas fa-comments"></i> {{ $article->comments_count }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($article->status == \App\Constant\PostStatus::Publish->value)
                                    已发布<br>{{ $article->published_at }}
                                @elseif($article->status == \App\Constant\PostStatus::Draft->value)
                                    草稿,最后修改<br>{{ $article->updated_at }}
                                @elseif($article->status == \App\Constant\PostStatus::Future->value)
                                    定时发布<br>{{ $article->published_at }}
                                @elseif($article->status == \App\Constant\PostStatus::Pending->value)
                                    待审,最后修改<br>{{ $article->updated_at }}
                                @elseif($article->status == \App\Constant\PostStatus::Trash->value)
                                    回收站,最后修改<br>{{ $article->updated_at }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $articles->links() }}
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
                console.log($(this).attr('data-id'))
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认移至回收站?',
                    text: "您确认要把该文章移至回收站吗？",
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

            $("a#pin").on('click', function (e, element) {
                e.preventDefault()
                console.log($(this).attr('data-id'))
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '@if(isset($article) && $article->pinned_at) 确认取消置顶 @else 确认置顶 @endif?',
                    text: '@if(isset($article) && $article->pinned_at) 请确认是否要把该篇文章取消置顶 @else 请确认是否要把该篇文章置顶 @endif?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-pin-' + id).submit()
                    }
                })
            });
        });
    </script>
@endsection
