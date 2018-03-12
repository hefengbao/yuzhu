@extends('admin.layouts.app')
@section('pageHeader')
    个人资料
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-12">
                @include('partials.errors')
            </div>
            <div class="box box-primary">
                <form action="{{ route('user.update',$user->id) }}" class="form-horizontal" method="post"
                      enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <input name="_method" type="hidden" value="PATCH">
                            <label for="avatar" class="control-label col-md-2">头像</label>
                            <div class="col-md-10">
                                <input type="file" id="avatar" name="avatar">
                                <p>图片格式为png、jpg、jpeg，下同</p>
                                @if($user->avatar)
                                    <img class="img_preview" src="{{ asset('storage/uploads/avatars/'.$user->avatar) }}"
                                         alt="">
                                @endif
                            </div>
                        </div>
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
                            <label for="website" class="control-label col-md-2">个人网站</label>
                            <div class="col-md-10">
                                <input type="text" id="website" name="website" class="form-control"
                                       value="{{ $user->website }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="github" class="control-label col-md-2">Github</label>
                            <div class="col-md-10">
                                <input type="text" id="github" name="github" class="form-control"
                                       value="{{ $user->github }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="weibo" class="control-label col-md-2">微博</label>
                            <div class="col-md-10">
                                <input type="text" id="weibo" name="weibo" class="form-control"
                                       value="{{ $user->weibo }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wechat" class="control-label col-md-2">微信账号二维码</label>
                            <div class="col-md-10">
                                <input type="file" id="wechat" name="wechat">
                                @if($user->wechat)
                                    <img class="img_preview" src="{{ asset('storage/'.$user->wechat) }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wechatpay" class="control-label col-md-2">微信支付二维码</label>
                            <div class="col-md-10">
                                <input type="file" id="wechatpay" name="wechatpay">
                                @if($user->wechatpay)
                                    <img class="img_preview" src="{{ asset('storage/'.$user->wechatpay) }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alipay" class="control-label col-md-2">支付宝二维码</label>
                            <div class="col-md-10">
                                <input type="file" id="alipay" name="alipay">
                                @if($user->alipay)
                                    <img class="img_preview" src="{{ asset('storage/'.$user->alipay) }}" alt="">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="control-label col-md-2">城市</label>
                            <div class="col-md-10">
                                <input type="text" id="city" name="city" class="form-control" value="{{ $user->city }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label col-md-2">公司</label>
                            <div class="col-md-10">
                                <input type="text" id="company" name="company" class="form-control"
                                       value="{{ $user->company }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="introduction" class="control-label col-md-2">个人简介</label>
                            <div class="col-md-10">
                                <textarea name="introduction" id="introduction" rows="5"
                                          class="form-control">{{ $user->introduction }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
