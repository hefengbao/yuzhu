<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@section('title')管理后台@show</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/iCheck/all.css') }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script>
        csrf_token = @csrf
        APP_URL = '<?php echo url('/') ?>';
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="javascript:;" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>One</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>O</b>ne</span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('home.index') }}" target="_blank" title="查看站点"><i class="fa fa-home"
                                                                                            aria-hidden="true"></i></a>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img
                                src="{{ Auth::user()->avatar ? asset('storage/uploads/avatars/'.Auth::user()->avatar) : asset('img/avatar.png') }}"
                                class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img
                                    src="{{ Auth::user()->avatar ? asset('storage/uploads/avatars/'.Auth::user()->avatar) : asset('img/avatar.png') }}"
                                    class="img-circle" alt="User Image">
                                <p>
                                {{ Auth::user()->name }}
                                <!--角色-->
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('user.profile',Auth::id()) }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">HEADER</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="{{ active_class(if_route_pattern(["dashboard.index"]),'active') }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fa fa-dashboard"></i> <span>仪表盘</span>
                    </a>
                </li>
                @canany(["post.index",'post.create',"category.index","tag.index"])
                    <li class="treeview {{ active_class(if_route_pattern(["post.*","tag.*","category.*"]),'active') }}">
                        <a href="#"><i class="fa fa-edit"></i> <span>文章</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @can(["post.index"])
                                <li class="{{ active_class(if_route_pattern(["post.index","post.edit"]),'active') }}">
                                    <a href="{{ url('admin/post') }}">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>所有文章
                                    </a>
                                </li>
                            @endcan
                            @can('post.create')
                                <li class="{{ active_class(if_route_pattern(["post.create"]),'active') }}">
                                    <a href="{{ url('admin/post/create') }}">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>写文章
                                    </a>
                                </li>
                            @endcan
                            @can(["category.index"])
                                <li class="{{ active_class(if_route_pattern(["category.*"]),'active') }}"><a
                                        href="{{ url('admin/category') }}"><i class="fa fa-circle-o"
                                                                              aria-hidden="true"></i>分类目录</a></li>
                            @endcan
                            @can(["tag.index"])
                                <li class="{{ active_class(if_route_pattern(["tag.*"]),'active') }}"><a
                                        href="{{ url('admin/tag') }}"><i class="fa fa-circle-o"
                                                                         aria-hidden="true"></i>标签</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(["page.index","page.create"])
                    <li class="treeview {{ active_class(if_route_pattern(["page.*"]),'active') }}">
                        <a href="#"><i class="fa fa-files-o"></i> <span>页面</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can("page.index")
                                <li class="{{ active_class(if_route_pattern(["page.index","page.edit"]),'active') }}">
                                    <a href="{{ url('admin/page') }}">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>所有页面
                                    </a>
                                </li>
                            @endcan
                            @can("page.create")
                                <li class="{{ active_class(if_route_pattern(["page.create"]),'active') }}">
                                    <a href="{{ url('admin/page/create') }}">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>新建页面
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['comment.index'])
                    <li class="treeview {{ active_class(if_route_pattern(["comment.*"]),'active') }}">
                        <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i> <span>评论</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('comment.index')
                                <li class="{{ active_class(if_route_pattern(["comment.index"]),'active') }}">
                                    <a href="{{ url('admin/comment') }}">
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>所有评论
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['appearance.menu'])
                    <li class="treeview {{ active_class(if_route_pattern(["appearance.*"]),'active') }}">
                        <a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span>外观</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('appearance.menu')
                                <li class="{{ active_class(if_route_pattern(["appearance.menu"]),'active') }}"><a
                                        href="{{ url('admin/appearance/menu') }}"><i class="fa fa-circle-o"
                                                                                     aria-hidden="true"></i>菜单</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['user.index','user.profile'])
                    <li class="treeview {{ active_class(if_route_pattern(["user.*"]),'active') }}">
                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span>用户</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('user.index')
                                <li class="{{ active_class(if_route_pattern(["user.index"]),'active') }}"><a
                                        href="{{ url('admin/user') }}"><i class="fa fa-circle-o" aria-hidden="true"></i>所有用户</a>
                                </li>
                            @endcan
                            @can('user.profile')
                                <li class="{{ active_class(if_route_pattern(["user.profile*"]),'active') }}"><a
                                        href="{{ url('admin/user/profile') }}/{{ Auth::id() }}"><i
                                            class="fa fa-circle-o" aria-hidden="true"></i>个人资料</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @role('admin')
                    <li class="treeview {{ active_class(if_route_pattern(["option.*"]),'active') }}">
                        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span>设置</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active_class(if_route_pattern(["option.index"]),'active') }}">
                                <a href="{{ url('admin/option') }}">
                                    <i class="fa fa-circle-o" aria-hidden="true"></i>基本
                                </a>
                            </li>
                            <li class="{{ active_class(if_route_pattern(["option.cache"]),'active') }}">
                                <a href="{{ route('option.cache') }}">
                                    <i class="fa fa-circle-o" aria-hidden="true"></i>缓存
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('pageHeader')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Version 1.0
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2017&nbsp;&nbsp;Powered by <a href="https://github.com/fenble/one">One</a>.</strong>
        All rights reserved.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/admin_app.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('script')
</body>
</html>
