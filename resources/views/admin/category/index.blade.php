@extends('admin.layouts.app')
@section('pageHeader')
类别目录
@stop
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="box box-warning">
               <div class="box-header with-border">新类别</div>
               <div class="box-body">
                   <form action="{{ route('category.store') }}" method="post">
                       {!! csrf_field() !!}
                       <div class="form-group">
                           <label for="" class="control-label">名称 <sup>*</sup></label>
                           <input type="text" id="tag_name" name="category_name" class="form-control" placeholder="名称" required>
                       </div>
                       <p>这将是它在站点上显示的名字。</p>
                       <div class="form-group">
                           <label for="" class="control-label">别名 <sup>*</sup></label>
                           <input type="text" id="tag_slug" name="category_slug" class="form-control" placeholder="别名" required>
                       </div>
                       <p>“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</p>
                       <div class="form-group">
                           <button class="btn btn-primary" type="submit">保存</button>
                       </div>
                   </form>
               </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="box box-danger">
            <div class="box-header with-border">分类目录列表</div>
            <div class="box-body">
                <table class="table table-bordered" id="posts-table">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>别名</th>
                        <th>总数</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    @foreach($categorys as $category)
                        <tr>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->category_slug }}</td>
                            <td>{{ $category->post_count }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </table>
                {!! $categorys->links() !!}
            </div>
        </div>
    </div>
</div>
@stop
