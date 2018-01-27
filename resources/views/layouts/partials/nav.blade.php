<ul class="nav navbar-nav">
    <li><a href="{{ route('home.index') }}">首页</a></li>
    <li><a href="{{ route('archive.index') }}">归档</a></li>
    {!! $menu !!}
</ul>

<ul class="nav navbar-nav navbar-right">
    <li><a href="{{ url('/feed') }}"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
</ul>