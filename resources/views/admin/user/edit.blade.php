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
                        <div class="form-group">
                            <label for="bio" class="control-label col-md-2">个人简介</label>
                            <div class="col-md-10">
                                <textarea name="bio" id="bio" rows="3"
                                          class="form-control">{{ $user->bio }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="_method" type="hidden" value="PATCH">
                            <label for="avatar" class="control-label col-md-2">头像</label>
                            <div class="col-md-10">
                                <input type="file" id="avatar" name="avatar" class="form-control">
                                <p>图片格式为png、jpg、jpeg，下同</p>
                                @if($user->avatar)
                                    <img class="img_preview" src="{{ asset('storage/uploads/avatars/'.$user->avatar) }}"
                                         alt="">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
