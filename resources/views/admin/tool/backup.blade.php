@extends('admin.layouts.app')
@section('title')
    数据备份- @parent
@endsection
@section('header')
    数据备份
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form class="form" action="{{ route('admin.tools.backup_run') }}" method="post">
                        @csrf
                        <button class="btn btn-sm btn-primary" type="submit">立即运行备份</button> <span class="text-sm text-secondary">备份数据大概要花费一点时间，请不要重复操作...</span>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>时间</th>
                            <th>文件</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($files as $key => $file)
                            <tr>
                                <td>{{ $file['datetime'] }}</td>
                                <td>{{ $file['name'] }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.tools.backup_download',$file['name']) }}">下载</a>
                                    <a class="btn btn-danger btn-sm" href="#" id="delete" data-id="{{ $key }}">删除</a>
                                    <form class="form" id="form-delete-{{ $key }}"
                                          action="{{ route('admin.tools.backup_delete') }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="file" value="{{ $file['name'] }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
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
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认删除?',
                    text: "您即将从您的站点删除备份文件，此操作不可恢复！",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-delete-' + id).submit()
                    }
                })
            });

            $("a#restore").on('click', function (e, element) {
                e.preventDefault()
                console.log($(this).attr('data-id'))
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认恢复?',
                    text: "您即将从您的站点恢复已删除的用户，恢复后，该用户可登录系统！",
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
