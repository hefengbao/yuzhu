@extends('admin.layouts.app')
@section('title')
    分录 - @parent
@endsection
@section('header')
    分类
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card card-outline card-default">
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">名称 <sup>*</sup></label>
                            <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp"
                                   required>
                            <div id="nameHelp" class="form-text text-muted">这将是它在站点上显示的名字。</div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label">别名 <sup>*</sup></label>
                            <input type="text" id="slug" name="slug" class="form-control" aria-describedby="slugHelp"
                                   required>
                            <div id="slugHelp" class="form-text text-muted">
                                “别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="control-label">父级分类 </label>
                            <select type="text" id="parent" name="parent" class="form-control"
                                    aria-describedby="parentHelp">
                                <option value="">无</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="parentHelp" class="form-text text-muted">
                                分类和标签不同，它可以有层级关系。您可以有一个名为“音乐”的分类，在该分类下可以有名为“流行”和“古典”的子分类（完全可选）。
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">添加新分类</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-outline card-default">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>别名</th>
                                <th>总数</th>
                            </tr>
                            </thead>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        {{ $category->name }}<br>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}">
                                            <span class="text-muted text-sm">编辑</span>
                                        </a>
                                        @if($category->id != 1)
                                            &nbsp;|&nbsp;
                                            <a href="#" id="delete" data-id="form-{{ $category->id }}">
                                                <span class="text-danger text-sm">删除</span>
                                            </a>
                                            <form class="form" id="form-{{ $category->id }}"
                                                  action="{{ route('admin.categories.destroy', $category->id) }}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->count }}</td>
                                </tr>

                                @foreach($category->child as $item)
                                    <tr>
                                        <td>
                                            — {{ $item->name }}<br>
                                            <a href="{{ route('admin.categories.edit', $item->id) }}">
                                                <span class="text-muted text-sm">编辑</span>
                                            </a>
                                            @if($item->id != 1)
                                                &nbsp;|&nbsp;
                                                <a href="#" id="delete" data-id="form-{{ $item->id }}">
                                                    <span class="text-danger text-sm">删除</span>
                                                </a>
                                                <form class="form" id="form-{{ $item->id }}"
                                                      action="{{ route('admin.categories.destroy', $item->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endif
                                        </td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->count }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <p class="text-muted">
                删除分类不会删除分类中的文章。然而，仅隶属于已删除分类的文章将会分入默认分类<b>{{ $categories->where('id',1)->first()->name }}</b>中。默认分类不能被删除。
            </p>
        </div>
    </div>
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("a#delete").on('click', function (e, element) {
                e.preventDefault()
                console.log($(this).attr('data-id'))
                let id = $(this).attr('data-id')
                Swal.fire({
                    title: '确认删除?',
                    text: "您即将从您的站点永久删除数据!此操作不能撤销!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: '确认删除',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form#' + id).submit()
                    }
                })
            });
        });
    </script>
@endsection
