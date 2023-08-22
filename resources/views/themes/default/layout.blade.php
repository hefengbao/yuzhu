<!--
Powered by https://github.com/hefengbao/one
-->
<!doctype html>
<html lang="zh">
@inject('options', 'App\Services\OptionService')
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="@yield('author')">
    <meta name="keywords" content="{{ $options->autoload()['keywords'] }}">
    <meta property="og:type" content="blog"/>
    <meta property="og:image" content="@yield('og_image')"/>
    <meta property="og:release_date" content="@yield('og_date')"/>
    <meta property="og:title" content="@yield('og_title')"/>
    <meta property="og:description" content="@yield('og_description')" />
    <meta property="og:author" content="@yield('og_author')"/>
    @if($options->autoload()['site_verify_meta']){!! $options->autoload()['site_verify_meta'] !!}@endif
    <title>@yield('title') {{ $options->autoload()['title'] }}@if(if_route('home.index')) &#8211; {{ $options->autoload()['subtitle'] }}@endif</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/5.2.3/css/bootstrap.min.css') }}"/>
    <style>
        body {
            font-family: Microsoft YaHei, -apple-system, BlinkMacSystemFont, Helvetica Neue, PingFang SC, Source Han Sans SC, Noto Sans CJK SC, WenQuanYi Micro Hei, sans-serif;
        }

        .container {
            max-width: 960px;
        }

        h1, h2, h3, h4, h5 {
            padding: 1rem 0 1rem 0;
        }

        .pagination {
            --bs-pagination-active-bg: rgb(0 0 0 / 80%);
            --bs-pagination-hover-color: rgb(0 0 0 / 92%);
        }

        .page-link {
            color: rgb(0 0 0 / 92%);
        }

        /*
         * Footer
         */
        .blog-footer {
            padding: 2.5rem 0;
            color: #727272;
            text-align: center;
            background-color: #f9f9f9;
        }

        .blog-footer p:last-child {
            margin-bottom: 0;
        }

        .avatar {
            width: 3rem;
            height: 3rem;
        }

        .avatar-rounded {
            border-radius: 50%;
        }

        .blog-post-body pre {
            background-color: #f6f6f6;
            padding: 1rem;
        }

        .blog-post-body blockquote {
            padding: 0.5rem 1rem;
            background-color: #f6f6f6;
            border-left: 0.5rem solid #bbbbbb;
        }

        .blog-post-body img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
        }

        .crawler {
            display: none !important;
        }
    </style>
    @yield('style')
    @if(isset($options->autoload()['site_analytics'])){!! $options->autoload()['site_analytics'] !!}@endif
</head>
<body>

<div class="container py-3">
    <header>
        <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <span class="fs-4">{{ $options->autoload()['title'] }}</span>
            </a>

            <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                <a class="me-3 py-2 text-dark text-decoration-none" href="/">首页</a>
                <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('tweets.index') }}">微博</a>
                <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('articles.index') }}">文章</a>
                <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('search.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </a>
                <a class="py-2 text-dark text-decoration-none" href="{{ url('/rss') }}">
                    <img width="16" height="16" src="{{ asset('image/rss.svg') }}" alt="">
                </a>
            </nav>
        </div>
    </header>
</div>

<main class="container">
    @yield('content')
    <div class="crawler">
        <p>来源：</p>
        <p><a href="{{ url()->current() }}">{{ url()->current() }}</a></p>
    </div>
</main>

<footer class="blog-footer">
    <p>Powered by <a href="https://hefengbao.github.io/one/" class="link-secondary">One</a></p>
    @if($icp = $options->autoload()['icp'])
        <p><a href="https://beian.miit.gov.cn/" class="link-secondary" target="_blank">{{ $icp }}</a></p>
    @endif
</footer>
@yield('script')
</body>
</html>
