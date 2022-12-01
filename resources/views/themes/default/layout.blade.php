<!--
One 一个简洁的博客、微博客系统。
https://github.com/hefengbao/one
-->
@inject('options', 'App\Services\OptionService')
    <!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="@yield('author')">
    <meta name="keywords" content="{{ $options->autoload()['keywords'] }}">
    <title>
        @yield('title') {{ $options->autoload()['title'] }}
        @if(if_route('home.index'))
            &#8211; {{ $options->autoload()['subtitle'] }}
        @endif
    </title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css"
          integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
            width: 45px;
            height: 45px;
        }

        .avatar-rounded {
            border-radius: 50%;
        }

        .editor-code {
            background-color: #f6f6f6;
            padding: 1rem;
        }

        .editor-quote {
            padding: 0.5rem 1rem;
            background-color: #f6f6f6;
            border-left: 0.33rem solid #bbbbbb;
        }

        .editor-quote :where(small) {
            font-style: italic;
        }

        .editor-warning {
            padding: 0.5rem 1rem;
            background-color: #f6f6f6;
            border-left: 0.33rem solid #ffa260;
        }

        .editor-image {
            text-align: center;
            padding: 1rem 0;
        }

        .editor-image img {
            width: 100%;
            height: auto;
        }

        .editor-image .editor-image-caption {
            min-width: 20%;
            max-width: 80%;
            min-height: 40px;
            display: inline-block;
            padding: 10px;
            margin: 0 auto;
            border-bottom: 1px solid #bbbbbb;
            font-size: 13px;
            color: #999;
        }

        .editor-embed-link {
            display: block;
            background: #fff;
            border: 1px solid rgba(201, 201, 204, 0.48);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            border-radius: 6px;
            will-change: filter;
            padding: 1rem;
            animation: link-in 450ms 1 cubic-bezier(0.215, 0.61, 0.355, 1);
            text-decoration: none;
            margin-top: 0.5rem;
        }

        .editor-embed-link__title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.5em;
            margin: 0 0 10px 0;
            color: #0a1520;
        }

        .editor-embed-link__description {
            margin: 0 0 20px 0;
            font-size: 15px;
            line-height: 1.55em;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #0a1520;
        }

        .editor-embed-link__domain {
            display: block;
            font-size: 15px;
            line-height: 1em;
            color: #888 !important;
            border: 0 !important;
            padding: 0 !important;
        }

        .editor-paragraph > a {
            color: #6c757d !important;
        }

        .crawler {
            display: none !important;
        }
    </style>
    @yield('style')
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
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
                <a class="me-3 py-2 text-dark text-decoration-none" href="{{ route('archives.index') }}">归档</a>
                <a class="py-2 text-dark text-decoration-none" href="{{ route('search.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
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
