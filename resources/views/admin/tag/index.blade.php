@extends('admin.layouts.app')
@section('title')
    标签列表 - @parent
@endsection
@section('header')
    标签列表
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card card-outline card-default">
                <div class="card-body">
                    <form action="{{ route('admin.tags.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">名称 <sup>*</sup></label>
                            <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp"
                                   required>
                            <div id="nameHelp" class="form-text text-muted">这将是它在站点上显示的名字。</div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label">别名 <sup>*</sup></label>
                            <input type="text" id="slug" name="slug" class="form-control" aria-describedby="slugHelp"
                                   required>
                            <p id="slugHelp" class="form-text text-muted">
                                “别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">添加新标签</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-outline card-default">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>别名</th>
                                <th>总数</th>
                            </tr>
                            </thead>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>
                                        {{ $tag->name }}<br>
                                        <a href="{{ route('admin.tags.edit', $tag->id) }}">
                                            <span class="text-muted text-sm">编辑</span>
                                        </a>
                                        &nbsp;|&nbsp;
                                        <a href="#" id="delete" data-id="form-{{ $tag->id }}">
                                            <span class="text-danger text-sm">删除</span>
                                        </a>
                                        <form class="form" id="form-{{ $tag->id }}"
                                              action="{{ route('admin.tags.destroy', $tag->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                    <td>{{ $tag->slug }}</td>
                                    <td>{{ $tag->count }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <p class="text-muted">删除标签不会删除标签中的文章。</p>
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
                    title: '确认删除?',
                    text: "您即将从您的站点永久删除数据!此操作不能撤销!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认删除',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form#' + id).submit()
                    }
                })
            });
        });
    </script>
@endsection
