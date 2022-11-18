@extends('admin.layouts.app')
@section('title')
    个人资料 - @parent
@endsection
@section('header')
    个人资料
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update',$user->id) }}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-2">用户名 <sup>*</sup></label>
                            <div class="col-md-10">
                                <input type="text" id="username" name="name" class="form-control"
                                       value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-2">邮箱 <sup>*</sup></label>
                            <div class="col-md-10">
                                <input type="text" id="email" name="email" class="form-control"
                                       value="{{ $user->email }}" required>
                            </div>
                        </div>
                        @if(auth()->user()->isAdministrator() && $user->id != 1)
                            <div class="form-group">
                                <label for="role" class="control-label col-md-2">角色 <sup>*</sup></label>
                                <div class="col-md-10">
                                    <select name="role" id="role" class="form-control">
                                        <option value="author" @selected($user->role == 'author')>作者</option>
                                        <option value="editor" @selected($user->role == 'editor')>编辑</option>
                                        <option value="administrator" @selected($user->role == 'administrator')>管理员
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <p class="text-muted">请谨慎授予管理员、编辑角色。</p>
                        @endif
                        <div class="form-group">
                            <label for="bio" class="control-label col-md-2">个人简介</label>
                            <div class="col-md-10">
                                <textarea name="bio" id="bio" rows="3" class="form-control">{{ $user->bio }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="control-label col-md-2">头像</label>
                            <div class="col-md-10">
                                <input type="file" id="avatar" name="avatar" class="form-control">
                                <p>图片格式为png、jpg、jpeg</p>
                                <img
                                    src="{{ $user->avatar ? url(Storage::url($user->avatar)) : Avatar::create($user->name)->setBackground('#adb5bd')->toBase64() }}"
                                    class="profile-user-img img-fluid img-circle" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">更新个人资料</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
