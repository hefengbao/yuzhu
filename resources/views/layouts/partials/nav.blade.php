<ul class="nav navbar-nav">
    <li><a href="{{ route('home.index') }}">首页</a></li>
    <li><a href="{{ route('archive.index') }}">归档</a></li>
    {!! $menu !!}
</ul>

@if(Auth::check())
<ul class="nav navbar-nav navbar-right">
    @role('Admin')
    <li><a href="{{ route('dashboard.index') }}">管理后台</a></li>
    @endrole
    @role('User')
    <li><a href="{{ route('dashboard.index') }}">博客管理</a></li>
    @endrole
    <li><a href="{{ route('logout') }}">退出</a></li>
</ul>
@else
<ul class="nav navbar-nav navbar-right">
    <li><a href="{{ route('dashboard.index') }}">登录</a></li>
</ul>
@endif
