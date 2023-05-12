@extends('admin.layouts.app')
@section('header')
    常规选项
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.options.store') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="control-label col-md-2">站点标题</label>
                            <div class="col-md-10">
                                <input type="text" id="title" name="title" class="form-control"
                                       value="{{ $options['title'] }}" aria-describedby="titleHelp">
                                <div id="titleHelp" class="form-text text-muted">起个有趣的名字吧</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="control-label col-md-2">站点副标题</label>
                            <div class="col-md-10">
                                <input type="text" id="subtitle" name="subtitle" class="form-control"
                                       value="{{ $options['subtitle'] }}" aria-describedby="subtitleHelp">
                                <div id="subtitleHelp" class="form-text text-muted">用简洁的文字描述本站点</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="control-label col-md-2">站点关键词</label>
                            <div class="col-md-10">
                                <textarea id="subtitle" name="keywords" rows="2" class="form-control"
                                          aria-describedby="keywordsHelp">{{ $options['keywords'] }}</textarea>
                                <div id="keywordsHelp" class="form-text text-muted">
                                    定义个性化的关键词,请用英文逗号（,）分割
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=description"" class="control-label col-md-2">站点描述</label>
                            <div class="col-md-10">
                                <textarea name="description" id="description" rows="3" class="form-control" aria-describedby="descriptionHelp">{{ $options['description'] }}</textarea>
                                <div id="descriptionHelp" class="form-text text-muted">对站点的详细描述，200 字内</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icp" class="control-label col-md-2">ICP备案号</label>
                            <div class="col-md-10">
                                <input type="text" id="icp" name="icp" class="form-control" value="{{ $options['icp'] }}" aria-describedby="icpHelp">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icp" class="control-label col-md-2">搜索引擎验证 Meta</label>
                            <div class="col-md-10">
                                <textarea name="site_verify_meta" id="site_verify_meta" rows="5" class="form-control" aria-describedby="siteVerifyMetaHelp">{{ $options['site_verify_meta'] ?? '' }}</textarea>
                                <div id="siteVerifyMetaHelp" class="form-text text-muted">在常用的搜索引擎验证提交验证网站，可以借助平台提供的工具做一些运营分析等。百度：https://ziyuan.baidu.com， 必应：https://www.bing.com/webmasters，谷歌：https://search.google.com/search-console</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icp" class="control-label col-md-2">网站分析平台接入代码</label>
                            <div class="col-md-10">
                                <textarea name="site_analytics" id="site_analytics" rows="5" class="form-control" aria-describedby="siteAnalyticsHelp">{{ $options['site_analytics'] ?? '' }}</textarea>
                                <div id="siteAnalyticsHelp" class="form-text text-muted">谷歌：https://analytics.google.com</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="users_can_register" class="control-label col-md-2">注册功能</label>
                            <div class="col-md-10">
                                <select name="users_can_register" id="users_can_register" class="form-control"
                                        aria-describedby="canRegisterHelp">
                                    <option value="0" @selected($options['users_can_register'])>关闭</option>
                                    <option value="1" @selected($options['users_can_register'])>开启</option>
                                </select>
                                <div id="canRegisterHelp" class="form-text text-muted">
                                    如果开启，则意味着用户可注册并在本站点发布文章等。
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
