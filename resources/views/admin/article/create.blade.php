@extends('admin.layouts.app')

@section('title')
    撰写文章 - @parent
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/dist/flatpickr.min.css') }}"/>
@endsection

@section('header')
    撰写文章
@endsection

@section('content')
    <div class="card card-outline">
        <div class="card-body">
            <form action="{{ route('admin.articles.store') }}" class="form" method="post">
                @csrf
                <div class="form-group">
                    <label for="title" class="control-label">标题 <sup>*</sup></label>
                    <input id="title" type="text" class="form-control" name="title" placeholder="标题"
                           value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="slug" class="control-label">Slug</label>
                    <input id="slug" type="text" class="form-control" name="slug" placeholder="Slug（可选）"
                           value="{{ old('slug') }}" aria-describedby="slugHelp">
                    <div id="slugHelp" class="form-text text-muted">用于生成 SEO 友好的
                        URL,建议只包含字母、数字、-，能翻译成有意义的英文最好不过，格式示例：first-blog。建议70个字符以内。
                    </div>
                </div>
                <input type="hidden" name="editor_type" value="{{ $editor }}">
                <div class="form-group">
                    @if($editor == \App\Constant\Editor::Markdown->value)
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <textarea name="body" id="editor" class="form-control">{{ old('body') }}</textarea>
                    @else
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <div id="editor" style="border: #d2d6de solid 1px; padding: 10px"></div>
                        <input type="hidden" id="body" name="body">
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="excerpt">摘要</label>
                        <div class="form-group">
                            <textarea name="excerpt" id="excerpt" cols="30" rows="3" class="form-control"
                                      placeholder="（可选）" aria-describedby="excerptHelp"></textarea>
                            <div id="excerptHelp" class="form-text text-muted">建议25~160个字符之间。</div>
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
                                           id="checkbox{{ $category->id }}" value="{{ $category->id }}">
                                    <label class="form-check-label"
                                           for="checkbox{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @foreach($category->child as $child)
                                    <div class="form-check icheck-blue">
                                        &nbsp;&nbsp;<input class="form-check-input" type="checkbox" name="category[]"
                                                           id="checkbox{{ $child->id }}" value="{{ $child->id }}">
                                        <label class="form-check-label"
                                               for="checkbox{{ $child->id }}">{{ $child->name }}</label>
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
                                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="tagHelp" class="form-text text-muted">含义清晰明确的标签有助于您检索查找。</div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status" class="form-label">状态</label>
                            <select name="status" id="status" class="form-control">
                                <option value="draft">草稿</option>
                                <option value="publish">发布</option>
                                <option value="future">定时发布</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label">定时发布时间</label>
                            <input type="date" min="{{ date('Y-m-d') }}" name="published_at" id="published_at"
                                   class="form-control" aria-describedby="publishHelp">
                            <div id="publishHelp" class="form-text text-muted">仅在状态为『定时发布』时生效。</div>
                        </div>
                        <div class="form-group">
                            <label for="commentable" class="form-label">评论</label>
                            <select name="commentable" id="commentable" class="form-control">
                                <option value="open">开启</option>
                                <option value="closed">关闭</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="submit" class="btn btn-primary" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @if($editor == \App\Constant\Editor::Markdown->value)
        @include('admin.common.markdown_editor')
    @else
        @include('admin.common.editorjs_editor')
    @endif
    @include('admin.common.tags_select')
@endsection
