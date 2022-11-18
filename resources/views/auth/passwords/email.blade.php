@extends('auth.app')

@section('content')
    <p class="login-box-msg">重置密码</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="邮箱地址" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary">
                    发送密码重置链接
                </button>
            </div>
        </div>
    </form>
@endsection
