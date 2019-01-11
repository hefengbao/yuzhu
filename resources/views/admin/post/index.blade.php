@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop
@section('pageHeader')
    所有文章
@stop
@section('content')
    @inject('tagPresenter','App\Presenters\TagPresenter')
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="{{ route('post.create') }}" class="btn btn-primary">写文章</a>
        </div>
        <div class="box-body">
            @include('partials.errors')
            @include('partials.success')
            <table class="table table-bordered table-responsive table-striped" id="posts-table" style="table-layout:fixed">
                <thead>
                <tr>
                    <th>标题</th>
                    <th>作者</th>
                    <th>分类目录</th>
                    <th>标签</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->post_title }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category->category_name }}</td>
                        <td>
                            {!! $tagPresenter->showTags($post->tags) !!}
                        </td>
                        <td>{{ $post->published_at }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('article.index',$post->post_slug) }}"
                               target="_blank" title="查看"><i class="fa fa-eye" aria-hidden="true"></i> </a>
                            <a class="btn btn-success btn-sm" href="{{ route('post.edit',$post->id)  }}" title="编辑"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                            <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display: inline;"
                                  onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-sm btn-danger" title="删除"><i class="fa fa-trash"
                                                                                       aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {!! $posts->links() !!}
        </div>
    </div>
@stop
