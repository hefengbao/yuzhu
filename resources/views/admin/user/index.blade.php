@extends('admin.layouts.app')
@section('pageHeader')
    所有用户
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">用户列表</div>
                <div class="box-body">
                    <table class="table table-bordered" id="posts-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('user.profile',$user->id) }}"><i
                                                class="fa fa-eye" aria-hidden="true"></i> 查看</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
@stop
