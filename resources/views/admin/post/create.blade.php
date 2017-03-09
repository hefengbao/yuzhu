@extends('admin.layouts.app')
@section('title')
    撰写新文章 - @parent
@stop
@section('css')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
@stop
@section('pageHeader')
    撰写新文章
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @include('partials.errors')
    </div>
    <form action="{{ route('post.store') }}" class="form" method="post">
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header with-border">撰写</div>
                <div class="box-body">
                    <div class="form-group {{ $errors->has('post_title') ? ' has-error' : '' }}">
                        <label for="post_title" class="control-label">标题 <sup>*</sup></label>
                        <input id="post_title" type="text" class="form-control" name="post_title" placeholder="标题" value="{{ old('post_title') }}" required>
                        @if ($errors->has('post_title'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('post_slug') ? ' has-error' : '' }}">
                        <label for="post_slug" class="control-label">链接 <sup>*</sup></label>
                        <input id="post_slug" type="text" class="form-control" name="post_slug" placeholder="链接" value="{{ old('post_slug') }}" required>
                        @if($errors->has('post_slug'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('post_slug') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('post_content') ? ' has-error' : '' }}">
                        <label for="post_content" class="control-label">内容 <sup>*</sup></label>
                        <div class="bao-editor" id="bao-editor">
                            <textarea id="post_content" name="post_content" class="form-control" rows="40" placeholder="Enter ...">{{ old('post_content')}}</textarea>
                            @if($errors->has('post_content'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('post_content') }}</strong>
                                    </span>
                            @endif
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
                        <label for="post_category">分类目录</label>
                        <select class="form-control" name="post_category" id="post_category">
                            @foreach($categories as $category)
                                @if( old('post_category')=== $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_tag">标签</label>
                        <select id="post_tag" name="tags[]" class="form-control select2" multiple style="width: 100%;">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->tag_name }}">{{ $tag->tag_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_excerpt" class="control-label">摘要</label>
                        <textarea id="post_excerpt" name="post_excerpt" class="form-control" rows="5" placeholder="200字以内" >{{ old('post_excerpt') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">开启评论</label>
                        <select class="form-control" name="comment_status">
                            @if(isset($post))
                                <option value="1" {{ old('comment_status') === 1 ? 'selected':'' }}>是</option>
                                <option value="0" {{ old('comment_status') === 0 ? 'selected':'' }}>否</option>
                            @else
                                <option value="1" selected>是</option>
                                <option value="0">否</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">保存状态</label>
                        <select class="form-control" name="post_status">
                            @if(isset($post))
                                <option value="1" {{ old('post_status') === 1 ? 'selected':'' }}>发布</option>
                                <option value="2" {{ old('post_status') === 2 ? 'selected':'' }}>草稿</option>
                            @else
                                <option value="1" selected>发布</option>
                                <option value="2">草稿</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">发布日期</label>
                        <input type="text" class="form-control pull-right" id="published_at" name="published_at" value="{{ isset($post) ? date_format($post->published_at,'m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y') }}">
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
@include('admin.layouts.partials.md-image-upload')
@stop

@section('script')
    <script src="//cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('js/markdown.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#post_tag").select2({
            tags: true
        });
        $('#published_at').datepicker({
            autoclose: true
        });
    });
</script>
@stop