@extends('admin.layouts.app')
@section('pageHeader')
评论管理
@stop
@section('content')
<div class="box box-default">
    <div class="box-body">
        @include('partials.errors')
        @include('partials.success')
        <table class="table table-bordered" id="posts-table">
            <thead>
            <tr>
                <th>文章 ID</th>
                <th>姓名</th>
                <th>邮箱</th>
                <th>IP</th>
                <th>内容</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            </thead>
            @foreach($comments as $item)
                <tr>
                    <td>{{ $item->post_id }}</td>
                    <td>{{ $item->comment_author }}</td>
                    <td>{{ $item->comment_author_email }}</td>
                    <td>{{ $item->comment_author_ip }}</td>
                    <td>{!! $item->comment_content_filter !!}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <form action="{{ route('comment.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> 删除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $comments->links() !!}
    </div>
</div>
@stop
