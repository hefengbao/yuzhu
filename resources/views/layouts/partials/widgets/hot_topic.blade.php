<div class="sidebar-module">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>热门文章</h4>
            <ol class="categories list-unstyled">
                @foreach($hotTopics as $hotTopic)
                    <li>
                        <a href="{{ url('/article') }}/{{ $hotTopic->post_slug }}"
                           title="{{ $hotTopic->post_title }}">{{ $hotTopic->post_title }}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div><!-- /.sidebar-module -->