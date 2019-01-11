<div class="sidebar-module">
    <form method="GET" action="{{ route('search.index') }}" accept-charset="UTF-8">
        <div class="form-group">
            <input class="form-control" placeholder="Search" name="q" type="text"
                   value="{{ (Request::is('search*') && isset($query)) ? $query : '' }}">
        </div>
    </form>
</div><!-- /.sidebar-module -->

@if(isset($single))
    <div class="sidebar-module">
        <div class="panel panel-default">
            <div class="panel-body text-center" id="author">
                <a href="{{ route('author.show',$post->user->id) }}"><img
                            src="{{ $post->user->avatar!=null ? asset('storage/uploads/avatars/'.$post->user->avatar):asset('img/avatar.png') }}"
                            alt="avatar" class="avatar avatar-img-thumbnail" style="margin: 5px;"></a>
                <p><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;<a
                            href="{{ route('author.show',$post->user->id) }}">{{ $post->user->name }}</a></p>
                <p><i>{{ $post->user->introduction }}</i></p>
                <p class="user-profile">
                    @if($post->user->website)
                        <a href="http://{{$post->user->website}}" rel="nofollow" target="_blank"
                           class="label label-light label-default">
                            <i class="fa fa-globe"></i> 个人网站
                        </a>
                    @endif
                    @if($post->user->github)
                        <a href="https://{{$post->user->github}}" class="label label-light label-default"
                           target="_blank">
                            <i class="fa fa-github-alt"></i> GitHub
                        </a>
                    @endif
                    @if ($post->user->weibo)
                        <a href="{{ $post->user->weibo }}" rel="nofollow" class="label label-light label-default"
                           target="_blank"><i class="fa fa-weibo"></i> 微博</a>
                    @endif
                    @if($post->user->wechat)
                        <a href="javascript:;" class="label label-light label-default"
                           data-content="<img src='{{ asset($post->user->wechat) }}'>" data-toggle='popover'>
                            <i class="fa fa-wechat"></i> 微信
                        </a>
                    @endif
                    @if ($post->user->company)
                        <a href="javaccript:;" class="label label-light label-default"
                           data-content="{{ $post->user->company }}" data-toggle='popover'><i class="fa fa-users"></i>
                            公司</a>
                    @endif

                    @if ($post->user->city)
                        <a href="javaccript:;" class="label label-light label-default"
                           data-content="{{ $post->user->city }}" data-toggle='popover'><i class="fa fa-map-marker"></i>
                            城市</a>
                    @endif
                </p>
            </div>
        </div>
    </div><!-- /.sidebar-module -->
@else
    <div class="sidebar-module">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>@if(isset($title)) {{ $title }} @endif</h4>
                <p>@if(isset($subtitle)) {{ $subtitle }} @endif </p>
            </div>
        </div>
    </div><!-- /.sidebar-module -->
@endif

@include('layouts.partials.widgets.category')
@include('layouts.partials.widgets.hot_topic')
@include('layouts.partials.widgets.tag')

