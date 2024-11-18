@inject('options', 'App\Services\OptionService')
@extends('themes.default.layout')
@section('description')
    {{ $options->autoload()['description'] }}
@endsection
@section('style')
    <style>
        .home {
            max-width: 960px;
            margin: 0 auto;
        }

        .home h1 {
            text-align: center;
        }

        .home h2 {
            text-align: center;
        }

        .home h3 {
            text-align: center;
        }

        .home h4 {
            text-align: center;
        }

        .home p {
            text-align: center;
        }

        .home .grid {
            text-align: center;
        }

        .grid a {
            padding: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="home">
        {!! \Illuminate\Support\Str::markdown($post->body) !!}
    </div>
@endsection
