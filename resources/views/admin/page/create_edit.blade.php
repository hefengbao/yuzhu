@extends('admin.layouts.app')

@section('title')
    @if(!isset($page))撰写页面@else编辑页面@endif - @parent
@endsection

@section('header')
    @if(!isset($page))撰写页面@else编辑页面@endif
@endsection

@section('content')
    <div class="card card-outline">
        <div class="card-body">
            @if(!isset($page))
                <form action="{{ route('admin.pages.store') }}" class="form" method="post">
                    @csrf
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="title" class="control-label">标题 <sup>*</sup></label>
                        <input id="title" type="text" class="form-control" name="title" placeholder="标题" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <textarea id="editor" name="body" class="form-control">{{ old('body') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="excerpt">摘要</label>
                            <div class="form-group">
                                <textarea name="excerpt" id="excerpt" cols="30" rows="3" class="form-control" placeholder="（可选）100 字以内"></textarea>
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
                            <button id="submit" class="btn btn-primary" type="submit">提交
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('admin.pages.update', $page->id) }}" class="form" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="title" class="control-label">标题 <sup>*</sup></label>
                        <input id="title" type="text" class="form-control" name="title" placeholder="标题" value="{{ $page->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="control-label">Slug <sup>*</sup></label>
                        <input id="slug" type="text" class="form-control" name="slug" placeholder="Slug" value="{{ $page->slug }}" required>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <textarea id="editor" name="body" class="form-control">{{ old('body', $page->body) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="excerpt">摘要</label>
                            <div class="form-group">
                                <textarea name="excerpt" id="excerpt" rows="3" class="form-control" placeholder="（可选）100 字以内">{{ $page->excerpt }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="status">状态</label>
                            <div class="form-group">
                                <select name="status" id="status" class="form-control">
                                    <option value="publish" @selected($page->status == 'publish')>发布</option>
                                    <option value="draft" @selected($page->status == 'draft')>草稿</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button id="submit" class="btn btn-primary" type="submit">更新</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
    @include('admin.common.markdown_editor')
    @include('admin.common.tags_select')
@endsection
