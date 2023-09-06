<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <title>@section('title')One 管理后台@show</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/4.6.2/css/bootstrap.min.css') }}"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libs/font-awesome/5.15.4/css/all.min.css') }}"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('libs/adminlte/3.2.0/css/adminlte.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('libs/toastr.js/latest/css/toastr.min.css') }}">
    <style>
        blockquote {
            border-left: none;
        }
    </style>
    @yield('css')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" target="_blank" class="nav-link" title="查看站点"><i class="fas fa-globe"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" title="用户资料卡">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <img
                        src="{{ auth()->user()->avatar ? url(Storage::url(auth()->user()->avatar)): Avatar::create(auth()->user()->name)->setBackground('#adb5bd')->toBase64() }}"
                        class="dropdown-item dropdown-header profile-user-img img-fluid img-circle mt-2 mb-2 p-2"
                        alt="">
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.users.edit', auth()->id()) }}" class="dropdown-item">
                        <i class="fas fa-id-card mr-2"></i> {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.users.edit', auth()->id()) }}" class="dropdown-item">
                        <i class="fas fa-edit mr-2"></i> 编辑资料
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-right-from-bracket mr-2"></i> 注销
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="全屏">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-1">
        <!-- Brand Logo -->
        <a href="#" class="brand-link elevation-1">
            <img src="{{ asset('image/one-logo.png') }}" alt="One Logo" class="brand-image img-circle elevation-1">
            <span class="brand-text font-weight-light">管理后台</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.index') }}"
                           class="nav-link {{ active_class(if_route_pattern(["admin.dashboard.index"])) }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>仪表盘</p>
                        </a>
                    </li>
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.articles.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.articles.*"])) }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>文章<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.articles.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.articles.index","admin.articles.edit"])) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>所有文章</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.articles.create')}}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.articles.create"])) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>写文章</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.tweets.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.tweets.*"])) }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <p>微博<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.tweets.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.tweets.index","admin.tweets.edit"])) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>所有微博</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.tweets.create')}}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.tweets.create"])) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>写微博</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @roles(['administrator'])
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.pages.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.pages.*"])) }}">
                            <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                            <p>页面<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.pages.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.pages.index","admin.pages.edit"])) }}">
                                    <i class="far fa-circle nav-icon"></i>所有页面
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pages.create') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.pages.create"])) }}">
                                    <i class="far fa-circle nav-icon"></i>新建页面
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endroles
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.comments.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.comments.*"])) }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>评论<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.comments.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.comments.index"])) }}">
                                    <i class="far fa-circle nav-icon"></i>所有评论
                                </a>
                            </li>
                        </ul>
                    </li>
                    @roles(['administrator'])
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.categories.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.categories.*"])) }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>分类<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.categories.*"])) }}">
                                    <i class="far fa-circle nav-icon"></i>分类目录
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.tags.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.tags.*"])) }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>标签<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.tags.index')}}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.tags.*"])) }}">
                                    <i class="far fa-circle nav-icon"></i>标签目录
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endroles
                    @roles(['administrator'])
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.users.*",'admin.user.*']), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.users.*",'admin.user.*'])) }}">
                            <i class="nav-icon fas fa-user" aria-hidden="true"></i>
                            <p>用户<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.users.index"])) }}">
                                    <i class="far fa-circle nav-icon"></i>所有用户
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.create') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.users.create"])) }}">
                                    <i class="far fa-circle nav-icon"></i>添加用户
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.edit', auth()->id()) }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.users.edit"])) }}">
                                    <i class="far fa-circle nav-icon"></i>个人资料
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user.settings.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.user.settings.index"])) }}">
                                    <i class="far fa-circle nav-icon"></i>个人设置
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.users.*",'admin.user.*']), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.users.*",'admin.user.*'])) }}">
                            <i class="nav-icon fas fa-user" aria-hidden="true"></i>
                            <p>用户<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.edit', auth()->id()) }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.users.edit"])) }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>个人资料</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user.settings.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.user.settings.index"])) }}">
                                    <i class="far fa-circle nav-icon"></i>个人设置
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endroles
                    @roles(['administrator'])
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.options.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.options.*"])) }}">
                            <i class="nav-icon fas fa-cog" aria-hidden="true"></i>
                            <p>设置<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.options.index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.options.index"])) }}">
                                    <i class="far fa-circle nav-icon"></i>常规
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ active_class(if_route_pattern(["admin.tools.*"]), 'menu-open') }}">
                        <a href="#" class="nav-link {{ active_class(if_route_pattern(["admin.tools.*"])) }}">
                            <i class="nav-icon fas fa-tools" aria-hidden="true"></i>
                            <p>工具<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.tools.backup_index') }}"
                                   class="nav-link {{ active_class(if_route_pattern(["admin.tools.backup_index","admin.tools.backup_download","admin.tools.backup_delete"])) }}">
                                    <i class="far fa-circle nav-icon"></i>数据备份
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endroles
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('header')</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; {{ date('Y') }}&nbsp;&nbsp;Powered by <a
                href="https://github.com/hefengbao/one" target="_blank">One</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('libs/jquery/3.6.0/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/adminlte/3.2.0/js/adminlte.min.js') }}"></script>
<script src="{{ asset('libs/toastr.js/latest/js/toastr.min.js') }}"></script>
<script src="{{ asset('libs/popper.js/1.16.1/umd/popper.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    toastr.options = {
        positionClass: 'toast-bottom-right'
    }
    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error('{{ $error }}')
    @endforeach
    @endif
    @if(session('success'))
    toastr.success('{{ session('success') }}')
    @endif
</script>
@yield('script')
</body>
</html>
