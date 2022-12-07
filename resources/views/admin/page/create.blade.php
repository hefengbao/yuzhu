@extends('admin.layouts.app')
@section('title')
    撰写新页面 - @parent
@endsection
@include('admin.page._style')
@section('header')
    撰写新页面
@endsection
@section('content')
    <div class="card card-outline">
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" class="form" method="post">
                @csrf
                <input type="hidden" id="body" name="body">
                <div class="form-group">
                    <label for="title" class="control-label">标题 <sup>*</sup></label>
                    <input id="title" type="text" class="form-control" name="title" placeholder="标题"
                           value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="editor" class="control-label">内容 <sup>*</sup></label>
                    <div id="editor" style="border: #d2d6de solid 1px; padding: 10px"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="excerpt">摘要</label>
                        <div class="form-group">
                            <textarea name="excerpt" id="excerpt" cols="30" rows="3" class="form-control"
                                      placeholder="（可选）100 字以内"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="status">状态</label>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="publish">发布</option>
                                <option value="draft">草稿</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button id="submit" class="btn btn-primary" type="submit" @disabled(old('body') == null)>提交
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@include('admin.page._script')
