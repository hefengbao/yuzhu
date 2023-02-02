@extends('admin.layouts.app')
@section('title')
    页面列表 - @parent
@endsection
@section('header')
    页面列表 <a href="{{ route('admin.pages.create') }}" class="btn btn-outline-primary btn-sm">新建页面</a>
@endsection
@section('content')
    <div class="row p-2">
        <div class="sub col-md-12">
            <a href="{{ route('admin.pages.index') }}"
               class="bg-aqua-active"><span>全部 ({{ $metrics['total'] }})</span></a>
            @if($metrics['publish_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.pages.index') }}?status=publish"><span>已发布 ({{ $metrics['publish_total'] }})</span></a>
            @endif
            @if($metrics['draft_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.pages.index') }}?status=draft"><span>草稿 ({{ $metrics['draft_total'] }})</span></a>
            @endif
            @if($metrics['trash_total'])
                &nbsp;|&nbsp;<a href="{{ route('admin.pages.index') }}?status=trash"><span>回收站 ({{ $metrics['trash_total'] }})</span></a>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{ route('pages.show', $page->slug_id) }}" target="_blank">{{ $page->title }}<br></a>
                                <a href="{{ route('admin.pages.edit', $page->id) }}">
                                    <span class="text-muted text-sm">编辑</span>
                                </a>
                                @if($page->status != \App\Constant\PostStatus::Trash->value)
                                    &nbsp;|&nbsp;
                                    <a href="#" id="delete" data-id="{{ $page->id }}">
                                        <span class="text-danger text-sm">移至回收站</span>
                                    </a>
                                    <form class="d-none" id="form-trash-{{ $page->id }}"
                                          action="{{ route('admin.pages.destroy', $page->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if($page->status == \App\Constant\PostStatus::Publish->value)
                                    已发布<br>{{ $page->published_at }}
                                @elseif($page->status == \App\Constant\PostStatus::Draft->value)
                                    草稿,最后修改<br>{{ $page->updated_at }}
                                @elseif($page->status == \App\Constant\PostStatus::Future->value)
                                    定时发布<br>{{ $page->published_at }}
                                @elseif($page->status == \App\Constant\PostStatus::Pending->value)
                                    待审核,最后修<br>{{ $page->updated_at }}
                                @elseif($page->status == \App\Constant\PostStatus::Trash->value)
                                    回收站,最后修<br>{{ $page->updated_at }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("a#delete").on('click', function (e, element) {
                e.preventDefault()
                console.log($(this).attr('data-id'))
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认移至回收站?',
                    text: "您确认要把该页面移至回收站吗？",
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
