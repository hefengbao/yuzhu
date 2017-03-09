@extends('admin.layouts.app')
@section('css')
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
@stop
@section('pageHeader')
新建页面
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')
        </div>
        <form action="{{ route('page.store') }}" class="form" method="post">
            <div class="col-md-8">
                <div class="box box-danger">
                    <div class="box-header with-border">撰写</div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="post_title" class="control-label">标题 <sup>*</sup></label>
                            <input id="post_title" type="text" class="form-control" name="post_title" placeholder="标题" value="{{ old('post_title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="post_slug" class="control-label">链接 <sup>*</sup></label>
                            <input id="post_slug" type="text" class="form-control" name="post_slug" placeholder="链接" value="{{ old('post_slug') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="post_content" class="control-label">内容 <sup>*</sup></label>
                            <div class="bao-editor" id="bao-editor">
                                <textarea id="post_content" name="post_content" class="form-control" rows="40" placeholder="Enter ...">{{ old('post_content') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">设置</div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="post_excerpt" class="control-label">摘要</label>
                            <textarea id="post_excerpt" name="post_excerpt" class="form-control" rows="5" placeholder="200字以内" >{{ old('post_excerpt') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">开启评论</label>
                            <select class="form-control" name="comment_status">
                                <option value="1">是</option>
                                <option value="0" selected>否</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('script')
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({
            spellChecker: false,
            element: document.getElementById("post_content"),
        });
    </script>
@stop
