<!doctype html>
<html lang="zh">
@inject('options', 'App\Services\OptionService')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="@if(if_route('home.index')){{ $options->autoload()['description'] ?? '' }}@else @yield('description') @endif">
    <meta name="keywords" content="{{ $options->autoload()['keywords'] ?? '' }}">
    <meta name="color-scheme" content="light dark">
    <meta property="og:type" content="blog"/>
    <meta property="og:image" content="@yield('og_image')"/>
    <meta property="og:release_date" content="@yield('og_date')"/>
    <meta property="og:title" content="@yield('og_title')"/>
    <meta property="og:description" content="@yield('og_description')"/>
    <meta property="og:author" content="@yield('og_author')"/>
    @if($options->autoload()['site_verify_meta'])
        {!! $options->autoload()['site_verify_meta'] !!}
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('/favicons/favicon.ico') }}">
    <link rel="icon" href="{{ asset('/favicons/favicon-16x16.png') }}" type="image/png" sizes="16x16">
    <link rel="icon" href="{{ asset('/favicons/favicon-32x32.png') }}" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('/favicons/apple-touch-icon.png') }}" type="image/png" sizes="180x180">
    <link rel="manifest" href="{{ asset('/favicons/site.webmanifest') }}">
    <link rel="stylesheet" href="{{ asset('libs/pico/pico.classless.zinc.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/pico/pico.colors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/theme-toggles/expand.min.css') }}">
    <style>
        .page-item {
            list-style: none;
            display: inline-block;
        }

        hgroup > h1 {
            margin-bottom: 1.5rem;
        }

        hgroup > p {
            font-weight: lighter;
        }
    </style>
    @yield('style')
    <title>@yield('title') {{ $options->autoload()['title'] }}@if(if_route('home.index'))
            &#8211; {{ $options->autoload()['subtitle'] }}
        @endif</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <a data-discover="true" href="{{ route('home.index') }}" style="text-decoration: none">
                    <strong>{{ $options->autoload()['title'] ?? config('app.name') }}</strong>
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="{{ route('home.index') }}" title="文章">首页</a>
            </li>
            <li>
                <a href="{{ route('articles.index') }}" title="文章">文章</a>
            </li>
            <li>
                <a href="{{ route('tweets.index') }}" title="微博">微博</a>
            </li>
            <li>
                <a href="{{ route('pages.index') }}" title="页面">页面</a>
            </li>
            <li>
                <a href="{{ route('search.index') }}" title="搜索查找">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                         class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </a>
            </li>
            <li>
                <a href="{{ route('feeds.main') }}" title="RSS" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-rss"
                         viewBox="0 0 16 16">
                        <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path
                            d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1zm0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1z"/>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" data-theme-switcher="dark" class="theme-toggle" title="Toggle theme"
                   aria-label="Toggle theme">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        width="1em"
                        height="1em"
                        fill="currentColor"
                        class="theme-toggle__expand"
                        viewBox="0 0 32 32"
                    >
                        <clipPath id="theme-toggle__expand__cutout">
                            <path d="M0-11h25a1 1 0 0017 13v30H0Z"/>
                        </clipPath>
                        <g clip-path="url(#theme-toggle__expand__cutout)">
                            <circle cx="16" cy="16" r="8.4"/>
                            <path
                                d="M18.3 3.2c0 1.3-1 2.3-2.3 2.3s-2.3-1-2.3-2.3S14.7.9 16 .9s2.3 1 2.3 2.3zm-4.6 25.6c0-1.3 1-2.3 2.3-2.3s2.3 1 2.3 2.3-1 2.3-2.3 2.3-2.3-1-2.3-2.3zm15.1-10.5c-1.3 0-2.3-1-2.3-2.3s1-2.3 2.3-2.3 2.3 1 2.3 2.3-1 2.3-2.3 2.3zM3.2 13.7c1.3 0 2.3 1 2.3 2.3s-1 2.3-2.3 2.3S.9 17.3.9 16s1-2.3 2.3-2.3zm5.8-7C9 7.9 7.9 9 6.7 9S4.4 8 4.4 6.7s1-2.3 2.3-2.3S9 5.4 9 6.7zm16.3 21c-1.3 0-2.3-1-2.3-2.3s1-2.3 2.3-2.3 2.3 1 2.3 2.3-1 2.3-2.3 2.3zm2.4-21c0 1.3-1 2.3-2.3 2.3S23 7.9 23 6.7s1-2.3 2.3-2.3 2.4 1 2.4 2.3zM6.7 23C8 23 9 24 9 25.3s-1 2.3-2.3 2.3-2.3-1-2.3-2.3 1-2.3 2.3-2.3z"/>
                        </g>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>
</header>
<main>
    @yield('content')
</main>
<footer>
    <hr>
    <p>Powered by <a href="https://hefengbao.github.io/yuzhu/" class="link-secondary"
                     target="_blank">Yuzhu</a>@if($icp = $options->autoload()['icp'])
            · <a href="https://beian.miit.gov.cn/" target="_blank">{{ $icp }}</a>
        @endif</p>
</footer>
<script src="{{ asset('libs/pico/minimal-theme-switcher.js') }}"></script>
@yield('script')
</body>
</html>
