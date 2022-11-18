@extends('admin.layouts.app')
@section('title')
    用户列表 - @parent
@endsection
@section('header')
    用户列表 <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary btn-sm">添加用户</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row p-2">
                <div class="sub col-md-12">
                    <a href="{{ route('admin.users.index') }}" class="bg-aqua-active"><span>全部 ({{ $metrics['total'] }})</span></a>
                    @if($metrics['administrator_total'])
                        &nbsp;|&nbsp;<a href="{{ route('admin.users.index') }}?role=administrator"><span>管理员 ({{ $metrics['administrator_total'] }})</span></a>
                    @endif
                    @if($metrics['editor_total'])
                        &nbsp;|&nbsp;<a href="{{ route('admin.users.index') }}?role=editor"><span>编辑 ({{ $metrics['editor_total'] }})</span></a>
                    @endif
                    @if($metrics['author_total'])
                        &nbsp;|&nbsp;<a href="{{ route('admin.users.index') }}?role=author"><span>作者 ({{ $metrics['author_total'] }})</span></a>
                    @endif
                    @if($metrics['trashed_total'])
                        &nbsp;|&nbsp;<a href="{{ route('admin.users.index') }}?trashed=true"><span>回收站 ({{ $metrics['trashed_total'] }})</span></a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>角色</th>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td>
                                    {{ $user->name }}<br>
                                    <a class="text-sm" href="{{ route('admin.users.edit',$user->id) }}">编辑</a>
                                    @if($user->id != 1)
                                        &nbsp;|&nbsp;
                                        @if($user->deleted_at)
                                            <a href="#" id="restore" data-id="{{ $user->id }}">
                                                <span class="text-danger text-sm">恢复</span>
                                            </a>
                                            <form class="form" id="form-restore-{{ $user->id }}"
                                                  action="{{ route('admin.users.restore', $user->id) }}" method="post">
                                                @csrf
                                                @method('patch')
                                            </form>
                                        @else
                                            <a href="#" id="delete" data-id="{{ $user->id }}">
                                                <span class="text-danger text-sm">删除</span>
                                            </a>
                                            <form class="form" id="form-delete-{{ $user->id }}"
                                                  action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $users->links() !!}
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
                    text: "您即将从您的站点删除用户，此操作将会使该用户无法登录系统！",
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
