<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@section('description')@if(isset($description)){{ $description }} @endif @show">
    <meta name="keywords" content="@section('keywords') @if(isset($keywords)){{ $keywords }} @endif @show">
    <meta name="author" content="@section('author'){{ url('/') }}@show">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@section('title')@if(isset($title)){{ $title }} @endif  @if(isset($subtitle)) - {{ $subtitle }} @endif @show</title>
    <script src="//cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
    <link href="//cdn.bootcss.com/normalize/5.0.0/normalize.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-material-design.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ripples.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-scrolltop.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/material-blog.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    @yield('css')
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        APP_URL = '<?php echo url('/') ?>'
    </script>
</head>
<body>
<div class="navbar navbar-material-blog navbar-primary navbar-absolute-top">
    <div class="navbar-image"
         style="background-image: url({{ asset('img/home-bg.jpg') }});background-position: center 40%;"></div>
    <div class="navbar-wrapper container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><i
                        class="material-icons">&#xE871;</i> @if(isset($title)){{ $title }}@else One @endif</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            @include('layouts.partials.nav')
        </div>
    </div>
</div>
<div class="container blog-content">
    @yield('content')
</div><!-- /.container -->
<footer class="blog-footer">
    <div id="links">
        <div class="container">
            <div class="row">
                <div class="col-sm-10">
                    <i class="material-icons brand"></i>
                    &copy;&nbsp;&nbsp;{{ date('Y')  }} &nbsp;&nbsp;Powered by <a
                            href="https://github.com/fenble/one">One</a>&nbsp;
                    @if(isset($icp))
                        &nbsp;<a href="http://www.miitbeian.gov.cn" target="_blank">{{ $icp }}</a>
                    @endif
                </div>
                <div class="col-md-2 text-right offset">
                    <ul class="list-inline">
                        <li><a href="{{ asset('sitemap.xml') }}" target="_blank">网站地图</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<button class="material-scrolltop primary" type="button"></button>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/ripples.min.js') }}"></script>
<script src="{{ asset('js/material.min.js') }}"></script>
<script src="{{ asset('js/material-scrolltop.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(document).ready(function () {
        $.material.init();
        $('body').materialScrollTop();
    });
</script>
@yield('script')
</body>
</html>
