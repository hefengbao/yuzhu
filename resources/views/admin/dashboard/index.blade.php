@extends('admin.layouts.app')
@section('pageHeader')仪表盘@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">&nbsp;</div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>系统类型</td>
                            <td>{{ $php_uname_s }}</td>
                        </tr>
                        <tr>
                            <td>系统版本号</td>
                            <td>{{ $php_uname_r }}</td>
                        </tr>
                        <tr>
                            <td>PHP版本号</td>
                            <td>{{ $php_version }}</td>
                        </tr>
                        <tr>
                            <td>Zend版本号</td>
                            <td>{{ $zend_version }}</td>
                        </tr>
                        <tr>
                            <td>PHP运行方式</td>
                            <td>{{ $php_sapi_name }}</td>
                        </tr>
                        <tr>
                            <td>服务器解析引擎</td>
                            <td>{{ $server_software }}</td>
                        </tr>
                        <tr>
                            <td>服务器地址</td>
                            <td>{{ $server_addr }}</td>
                        </tr>
                        <tr>
                            <td>服务器端口</td>
                            <td>{{ $server_port }}</td>
                        </tr>

                    </table>
                </div>
                <div class="box-footer">&nbsp;</div>
            </div>
        </div>
    </div>
@stop