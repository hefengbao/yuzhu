<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'One') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('libs/bootstrap/4.6.2/css/bootstrap.min.css') }}"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libs/font-awesome/5.15.4/css/all.min.css') }}"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('libs/adminlte/3.2.0/css/adminlte.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('libs/toastr.js/latest/css/toastr.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ url('/') }}" class="h1"><b>One</b></a>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<script src="{{ asset('libs/jquery/3.6.0/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/font-awesome/6.2.0/js/all.min.js') }}"></script>
<script src="{{ asset('libs/adminlte/3.2.0/js/adminlte.min.js') }}"></script>
<script src="{{ asset('libs/toastr.js/latest/js/toastr.min.js') }}"></script>
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
</body>
</html>
