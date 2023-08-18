@extends('admin.layouts.app')

@section('title')
    @if(!isset($tweet))撰写文章@else编辑文章@endif - @parent
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/dist/flatpickr.min.css') }}">
@endsection

@section('header')
    @if(!isset($tweet))撰写文章@else编辑文章@endif
@endsection

@section('content')
    <div class="card card-outline">
        <div class="card-body">
            @if(!isset($article))
                <form action="{{ route('admin.articles.store') }}" class="form" method="post">
                    @csrf
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="title" class="control-label">标题 <sup>*</sup></label>
                        <input id="title" type="text" class="form-control" name="title" placeholder="标题" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="control-label">Slug</label>
                        <input id="slug" type="text" class="form-control" name="slug" placeholder="Slug（可选）" value="{{ old('slug') }}">
                        <div id="slugHelp" class="form-text text-muted">用于生成 SEO 友好的 URL,建议只包含字母、数字、-，能翻译成有意义的英文最好不过，格式示例：first-blog。</div>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <textarea name="body" id="editor" class="form-control"></textarea>
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
                        <div class="col-md-4">
                            <label for="">分类</label>
                            <div class="form-group">
                                @foreach($categories as $category)
                                    <div class="form-check icheck-blue">
                                        <input class="form-check-input" type="checkbox" name="category[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}">
                                        <label class="form-check-label" for="checkbox{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                    @foreach($category->child as $child)
                                        <div class="form-check icheck-blue">
                                            &nbsp;&nbsp;<input class="form-check-input" type="checkbox" name="category[]" id="checkbox{{ $child->id }}" value="{{ $child->id }}">
                                            <label class="form-check-label" for="checkbox{{ $child->id }}">{{ $child->name }}</label>
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
                                <input type="date" min="{{ date('Y-m-d') }}" name="published_at" id="published_at" class="form-control" aria-describedby="publishHelp">
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
            @else
                <form action="{{ route('admin.articles.update', $article->id) }}" class="form" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="title" class="control-label">标题 <sup>*</sup></label>
                        <input id="title" type="text" class="form-control" name="title" placeholder="标题" value="{{ old('title', $article->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="control-label">Slug <sup>*</sup></label>
                        <input id="slug" type="text" class="form-control" name="slug" placeholder="Slug" value="{{ old('slug', $article->slug) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="editor" class="control-label">内容 <sup>*</sup></label>
                        <textarea name="body" id="editor" class="form-control">{{ old('body', $article->body) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="excerpt" class="form-label">摘要</label>
                                <textarea name="excerpt" id="excerpt" cols="30" rows="3" class="form-control" placeholder="（可选）100 字以内">{{ old('excerpt', $article->excerpt) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">分类</label>
                            <div class="form-group">
                                @foreach($categories as $category)
                                    <div class="form-check icheck-blue">
                                        <input class="form-check-input" type="checkbox" name="category[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}" @checked($article->categories->contains($category))>
                                        <label class="form-check-label" for="checkbox{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                    @foreach($category->child as $child)
                                        <div class="form-check icheck-blue">
                                            &nbsp;&nbsp;<input class="form-check-input" type="checkbox" name="category[]" id="checkbox{{ $child->id }}" value="{{ $child->id }}" @checked($article->categories->contains($child))>
                                            <label class="form-check-label" for="checkbox{{ $child->id }}"> {{ $child->name }}</label>
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
                                        <option value="{{ $tag->name }}" @selected($article->tags->contains($tag))>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="tagHelp" class="form-text text-muted">含义清晰明确的标签有助于您检索查找。</div>
                        </div>
                        <div class="col-md-4">
                            @if($article->status !== 'publish')
                            <div class="form-group">
                                <label for="status" class="form-label">状态</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="future" @if($article->status == 'future') selected @endif>定时发布</option>
                                    <option value="publish" @if($article->status == 'publish') selected @endif>发布</option>
                                    <option value="draft" @if($article->status == 'draft') selected @endif>草稿</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">定时发布时间</label>
                                <input type="date" min="{{ date('Y-m-d') }}" @if($article->published_at) value="{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $article->published_at)->format('Y-m-d') }}" @endif name="published_at" id="published_at" class="form-control" aria-describedby="publishHelp">
                                <div id="publishHelp" class="form-text text-muted">仅在状态为『定时发布』时生效。</div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="commentable" class="form-label">评论</label>
                                <select name="commentable" id="commentable" class="form-control">
                                    <option value="open">开启</option>
                                    <option value="closed">关闭</option>
                                </select>
                            </div>
                        </div>
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
<!--    <script src="{{ asset('libs/flatpickr/dist/flatpickr.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/dist/l10n/zh.js') }}"></script>
    <script>
        flatpickr("#published_at", {
            enableTime: true,
            enableSeconds: true,
            time_24hr: true,
            dateFormat: "Y-m-d H:i:S",
            minDate: "today",
            locale: "zh",
        });
    </script>-->
<!--    <script type="text/javascript">
        $(document).ready(function () {
            let _publishSetting = $('#publish_setting')
            let _publishedAt = $('#published_at')
            @if(isset($article) && $article && $article->status == 'future')
            _publishSetting.show()
            _publishedAt.prop("required", true);
            @else
            _publishSetting.hide()
            _publishedAt.prop("required", false);
            @endif

            let _status = $('#status');
            _status.on('change', function () {
                if ($(this).val() === 'future') {
                    _publishSetting.show()
                } else {
                    _publishSetting.hide()
                    $('#published_at').val(null)
                }
            })

        });
    </script>-->
@endsection
