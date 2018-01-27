<div class="sidebar-module">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>分类目录</h4>
            <ol class="categories list-unstyled">
                @foreach($categorys as $category)
                    <li>
                        <a href="{{ url('category') }}/{{ $category->category_slug }}">{{ $category->category_name}}</a>
                        {{--<span class="label label-light label-default pull-right">{{ $category->count }}</span>--}}
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div><!-- /.sidebar-module -->