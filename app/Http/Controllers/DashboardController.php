<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {

        //获取系统类型及版本号：
        //$php_uname = php_uname();     //(例：Windows NT COMPUTER 5.1 build 2600)

        //只获取系统类型：
        $php_uname_s = php_uname('s');       //(或：PHP_OS，例：Windows NT)

        //只获取系统版本号：
        $php_uname_r = php_uname('r');

        //获取PHP运行方式：
        $php_sapi_name = php_sapi_name();       //(PHP run mode：apache2handler)

        //获取PHP版本：
        $php_version = PHP_VERSION;

        //获取Zend版本：
        $zend_version = Zend_Version();

        $fp = popen('top -b -n 1 | grep -E "(Cpu|Mem|Tasks)"', "r");
        $rs = '';
        while (!feof($fp)) {
            $rs .= fread($fp, 1024);
        }
        pclose($fp);
        $sys_info = explode("\n", $rs);
        $servers = $_SERVER;
        return view('admin.dashboard.index')->with(['php_uname_s' => $php_uname_s, 'php_uname_r' => $php_uname_r, 'php_sapi_name' => $php_sapi_name, 'php_version' => $php_version, 'zend_version' => $zend_version, 'server_software' => $servers['SERVER_SOFTWARE'], 'server_addr' => $servers['SERVER_ADDR'], 'server_port' => $servers['SERVER_PORT'], 'sys_info' => $sys_info]);
    }
}
