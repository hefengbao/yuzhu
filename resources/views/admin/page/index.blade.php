@extends('admin.layouts.app')
@section('pageHeader')
所有页面
@stop
@section('content')
<div class="box box-default">
    <div class="box-header"><a href="{{ route('page.create') }}" class="btn btn-primary">新建页面</a></div>
    <div class="box-body">
        @include('partials.errors')
        <table class="table table-bordered" id="pages-table">
            <thead>
            <tr>
                <th>标题</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->post_title }}</td>
                    <td>{{ $page->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('page.show',$page->post_slug) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> 查看</a>
                        <a class="btn btn-success btn-sm" href="{{ route('page.edit',$page->id)  }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 编辑</a>
                        <form action="{{ route('page.destroy', $page->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> 删除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $pages->links() !!}
    </div>
    <div class="box-footer">&nbsp;</div>
</div>
@stop