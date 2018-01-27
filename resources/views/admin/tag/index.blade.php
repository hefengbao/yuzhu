@extends('admin.layouts.app')
@section('pageHeader')
    标签
@stop
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="box box-warning">
                <div class="box-header with-border">新标签</div>
                <div class="box-body">
                    <form action="{{ route('tag.store') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="" class="control-label">名称 <sup>*</sup></label>
                            <input type="text" id="tag_name" name="tag_name" class="form-control" placeholder="名称"
                                   required>
                        </div>
                        <p>这将是它在站点上显示的名字。</p>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-danger">
                <div class="box-header with-border">标签列表</div>
                <div class="box-body">
                    <table class="table table-bordered" id="posts-table">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>总数</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->tag_name }}</td>
                                <td>{{ $tag->post_count }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $tags->links() !!}
                </div>
            </div>
        </div>
    </div>
@stop