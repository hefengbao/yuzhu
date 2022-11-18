@extends('admin.layouts.app')
@section('title')
    编辑标签 - @parent
@endsection
@section('header')
    编辑标签
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-default">
                <div class="card-body">
                    <form action="{{ route('admin.tags.update', $tag->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="control-label">名称 <sup>*</sup></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $tag->name }}"
                                   aria-describedby="nameHelp" required>
                            <div id="nameHelp" class="form-text text-muted">这将是它在站点上显示的名字。</div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label">别名 <sup>*</sup></label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{ $tag->slug }}"
                                   aria-describedby="slugHelp" required>
                            <p id="slugHelp" class="form-text text-muted">
                                “别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">更新</button>
                            <a class="btn btn-default" href="{{ route('admin.tags.index') }}">取消</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
