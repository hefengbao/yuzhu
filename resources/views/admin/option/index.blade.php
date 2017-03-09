@extends('admin.layouts.app')
@section('pageHeader')
基本配置
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <form action="{{ route('option.store') }}" class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="control-label col-md-2">站点标题</label>
                        <div class="col-md-10">
                            <input type="text" id="title" name="title" class="form-control" value="{{ $option['title'] }}">
                            <p>起个响亮的名字吧</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subtitle" class="control-label col-md-2">站点副标题</label>
                        <div class="col-md-10">
                            <input type="text" id="subtitle" name="subtitle" class="form-control" value="{{ $option['subtitle'] }}">
                            <p>用简洁的文字描述本站点</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keyword" class="control-label col-md-2">站点关键词</label>
                        <div class="col-md-10">
                            <input type="text" id="subtitle" name="keywords" class="form-control" value="{{ $option['keywords'] }}">
                            <p>定义个性化的关键词</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for=description"" class="control-label col-md-2">站点描述</label>
                        <div class="col-md-10">
                            <textarea name="description" id="description" rows="3" class="form-control">{{ $option['description'] }}</textarea>
                            <p>对站点的详细描述，200字内</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icp" class="control-label col-md-2">ICP备案号</label>
                        <div class="col-md-10">
                            <input type="text" id="icp" name="icp" class="form-control" value="{{ $option['icp'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="close_register" class="control-label col-md-2">注册功能</label>
                        <div class="col-md-10">
                            <input type="checkbox" id="close_register" name="close_register" value="1" {{ $option['close_register']==1 ? 'checked':'' }}> 关闭注册
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
