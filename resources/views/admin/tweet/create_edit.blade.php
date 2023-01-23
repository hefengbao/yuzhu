@extends('admin.layouts.app')

@section('title')
    @if(!isset($tweet))撰写微博@else编辑微博@endif - @parent
@endsection

@section('header')
    @if(!isset($tweet))撰写微博@else编辑微博@endif
@endsection

@section('content')
    <div class="card card-outline">
        <div class="card-body">
            @if(!isset($tweet))
                <form action="{{ route('admin.tweets.store') }}" class="form" method="post">
                    @csrf
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="body" class="control-label">内容 <sup>*</sup></label>
                        <textarea id="body" class="form-control" name="body" placeholder="开始写作..." rows="5"
                                  required>{{ old('body') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="tags">标签</label>
                            <div class="select2-blue">
                                <select id="tags" name="tag[]" class="form-control" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
            @else
                <form action="{{ route('admin.tweets.update', $tweet->id) }}" class="form" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="body" name="body">
                    <div class="form-group">
                        <label for="body" class="control-label">内容 <sup>*</sup></label>
                        <textarea id="body" class="form-control" name="body" rows="5" required>{{ $tweet->body }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="tags">标签</label>
                            <div class="select2-blue">
                                <select id="tags" name="tag[]" class="form-control" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}"
                                                @if($tweet->tags->contains($tag)) selected @endif>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="commentable">评论</label>
                            <div class="form-group">
                                <select name="commentable" id="commentable" class="form-control">
                                    <option value="open" @if($tweet->commentable == 'open') selected @endif>开启</option>
                                    <option value="closed" @if($tweet->commentable == 'closed') selected @endif>关闭
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit">更新</button>
                            <a class="btn btn-default" href="{{ $pre }}">取消</a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
    @include('admin.common.tags_select')
@endsection
