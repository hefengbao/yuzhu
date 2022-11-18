@extends('admin.layouts.app')
@section('title')
    编辑文章 - @parent
@endsection
@include('admin.article._style')
@section('header')
    编辑文章
@endsection
@section('content')
    <div class="card card-outline">
        <div class="card-body">
            <form action="{{ route('admin.articles.update', $article->id) }}" class="form" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" id="body" name="body" value="{{ $article->body }}">
                <div class="form-group">
                    <label for="title" class="control-label">标题 <sup>*</sup></label>
                    <input id="title" type="text" class="form-control" name="title" placeholder="标题"
                           value="{{ $article->title }}" required>
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
                                      placeholder="（可选）100 字以内">{{ $article->excerpt }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">分类</label>
                        <div class="form-group">
                            @foreach($categories as $category)
                                <div class="form-check icheck-blue">
                                    <input class="form-check-input" type="checkbox" name="category[]"
                                           id="checkbox{{ $category->id }}"
                                           value="{{ $category->id }}" @checked($article->categories->contains($category))>
                                    <label class="form-check-label"
                                           for="checkbox{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @foreach($category->child as $child)
                                    <div class="form-check icheck-blue">
                                        &nbsp;&nbsp;<input class="form-check-input" type="checkbox" name="category[]"
                                                           id="checkbox{{ $child->id }}"
                                                           value="{{ $child->id }}" @checked($article->categories->contains($child))>
                                        <label class="form-check-label"
                                               for="checkbox{{ $child->id }}"> {{ $child->name }}</label>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="tags">标签</label>
                        <div class="select2-blue">
                            <select id="tags" name="tag[]" class="form-control" aria-describedby="tagHelp" multiple>
                                @foreach($tags as $tag)
                                    <option
                                        value="{{ $tag->name }}" @selected($article->tags->contains($tag))>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="tagHelp" class="form-text text-muted">含义清晰明确的标签有助于您检索查找。</div>
                    </div>
                    <div class="col-md-4">
                        <label for="status">状态</label>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="publish" @if($article->status == 'publish') selected @endif>发布</option>
                                <option value="future" @if($article->status == 'future') selected @endif>定时发布
                                </option>
                                <option value="draft" @if($article->status == 'draft') selected @endif>草稿</option>
                            </select>
                        </div>
                        <div class="form-group" id="publish_setting">
                            <div class="input-group date" id="publish" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#publish"
                                       name="published_at" id="published_at"
                                       value="@if($meta = $article->meta->where('meta_key','published_at')->first()){{ $meta->meta_value }}@endif">
                                <div class="input-group-append" data-target="#publish" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <p class="text-muted">请设置发布时间。</p>
                        </div>
                        <label for="commentable">评论</label>
                        <div class="form-group">
                            <select name="commentable" id="commentable" class="form-control">
                                <option value="open">开启</option>
                                <option value="closed">关闭</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.article._script')
@endsection
