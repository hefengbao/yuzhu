@extends('admin.layouts.app')
@section('title')
    编辑页面 - @parent
@stop
@section('css')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
@stop
@section('pageHeader')
    编辑页面
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @include('partials.errors')
        @include('partials.success')
    </div>
    <form method="POST" action="{{ route('page.update', $page->id) }}" accept-charset="UTF-8" id="topic-create-form">
        <input name="_method" type="hidden" value="PATCH">
        <div class="col-md-8">
            <div class="box box-danger">
                    <div class="box-header with-border">编辑</div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="post_title" class="control-label">标题 <sup>*</sup></label>
                            <input id="post_title" type="text" class="form-control" name="post_title" placeholder="标题" value="{{ $page->post_title }}" required>
                        </div>
                        <div class="form-group">
                                <label for="post_slug" class="control-label">链接 <sup>*</sup></label>
                                <input id="post_slug" type="text" class="form-control" name="post_slug" placeholder="链接" value="{{ $page->post_slug }}" required>
                        </div>
                        <div class="form-group">
                            <label for="post_content" class="control-label">内容 <sup>*</sup></label>
                            <div class="bao-editor" id="bao-editor">
                                <textarea id="post_content" name="post_content" class="form-control" rows="40" placeholder="Enter ...">{{ $page->post_content }}</textarea>
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
                        <textarea id="post_excerpt" name="post_excerpt" class="form-control" rows="5" placeholder="200字以内" >{{ $page->post_excerpt }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">开启评论</label>
                        <select class="form-control" name="comment_status">
                                <option value="1" {{ $page->comment_status === 1 ? 'selected':'' }}>是</option>
                                <option value="0" {{ $page->comment_status === 0 ? 'selected':'' }}>否</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    {{ csrf_field() }}
                    <button class="btn btn-primary" type="submit">更新</button>
                    <a class="btn btn-success" href="{{ route('page.index') }}">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('script')
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#post_tag").select2({
            tags: true
        });
        $('#published_at').datepicker({
            autoclose: true
        });
    });

    var simplemde = new SimpleMDE({
        spellChecker: false,
        element: document.getElementById("post_content"),

    });
</script>
@stop