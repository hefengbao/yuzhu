<div class="sidebar-module">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>标签云</h4>
                @foreach($tags as $tag)
                    <a href="{{ url('tag') }}/{{ $tag->tag_name }}"><span class="label label-light label-default">{{ $tag->tag_name }} </span></a>
                @endforeach
        </div>
    </div>
</div><!-- /.sidebar-module -->
