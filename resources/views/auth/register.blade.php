@extends('auth.app')
@inject('options', 'App\Services\OptionService')
@section('content')
    @if($options->autoload()['users_can_register'])
        <p class="login-box-msg">注册新账号</p>

        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input name="name" type="text" class="form-control" placeholder="用户名" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input name="email" type="email" class="form-control" placeholder="电子邮箱" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input name="password" type="password" class="form-control" placeholder="密码" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input name="password_confirmation" type="password" class="form-control" placeholder="确认密码"
                       required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                {{--<div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                        <label for="agreeTerms">
                            I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>--}}
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">注册</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">已有帐号？</a>
    @else
        <p class="login-box-msg">此山是我开，<br> 此树是我栽。<br>要想从此过，<br> 留下买路财！</p>
    @endif
@endsection
