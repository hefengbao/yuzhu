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
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="control-label">名称 <sup>*</sup></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $category->name }}"
                                   aria-describedby="nameHelp" required>
                            <div id="nameHelp" class="form-text text-muted">这将是它在站点上显示的名字。</div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label">别名 <sup>*</sup></label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{ $category->slug }}"
                                   aria-describedby="slugHelp" required>
                            <div id="slugHelp" class="form-text text-muted">
                                “别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="control-label">父级分类 </label>
                            <select type="text" id="parent" name="parent" class="form-control"
                                    aria-describedby="parentHelp">
                                <option value="" @selected($category->parent_id == null)>无</option>
                                @foreach($categories as $item)
                                    <option
                                        value="{{ $item->id }}" @selected($category->parent_id == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div id="parentHelp" class="form-text text-muted">
                                分类和标签不同，它可以有层级关系。您可以有一个名为“音乐”的分类，在该分类下可以有名为“流行”和“古典”的子分类（完全可选）。
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">更新</button>
                            <a class="btn btn-default" href="{{ route('admin.categories.index') }}">取消</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
