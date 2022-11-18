@extends('admin.layouts.app')
@section('title')
    添加用户 - @parent
@endsection
@section('header')
    添加用户
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label col-md-2">用户名 <sup>*</sup></label>
                            <div class="col-md-10">
                                <input type="text" id="username" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-2">邮箱 <sup>*</sup></label>
                            <div class="col-md-10">
                                <input type="text" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-md-2">密码 <sup>*</sup></label>
                            <div class="col-md-10">
                                <input type="text" id="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <p class="text-muted">密码至少 8 位</p>
                        <div class="form-group">
                            <label for="role" class="control-label col-md-2">角色 <sup>*</sup></label>
                            <div class="col-md-10">
                                <select name="role" id="role" class="form-control" required>
                                    <option value="author">作者</option>
                                    <option value="editor">编辑</option>
                                    <option value="administrator">管理员</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-muted">请谨慎授予管理员、编辑角色。</p>
                        <div class="form-group">
                            <button class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
