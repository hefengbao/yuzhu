@extends('admin.layouts.app')
@section('title')
    个人设置 - @parent
@endsection
@section('header')
    个人设置
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.user.settings.update') }}" class="form-horizontal" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editor_type" class="control-label col-md-2">默认编辑器</label>
                            <div class="col-md-10">
                                <select name="editor_type" id="editor_type" class="form-control">
                                    <option
                                        value="{{ \App\Constant\Editor::Markdown->value }}">{{ ucfirst(\App\Constant\Editor::Markdown->value) }}</option>
                                    <option
                                        value="{{ \App\Constant\Editor::Editorjs->value }}" @selected(isset($metas['editor_type']) && $metas['editor_type'] == \App\Constant\Editor::Editorjs->value)>{{ ucfirst(\App\Constant\Editor::Editorjs->value) }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">更新个人设置</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
