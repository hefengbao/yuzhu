<?php

namespace App\Http\Controllers\Admin;

use App\Constant\CommentStatus;
use App\Constant\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        //获取系统类型及版本号：
        //$php_uname = php_uname();     //(例：Windows NT COMPUTER 5.1 build 2600)

        //只获取系统类型：
        //$php_uname_s = php_uname('s');       //(或：PHP_OS，例：Windows NT)

        //只获取系统版本号：
        //$php_uname_r = php_uname('r');

        //获取PHP运行方式：
        //$php_sapi_name = php_sapi_name();       //(PHP run mode：apache2handler)

        //获取PHP版本：
        //$php_version = PHP_VERSION;

        //获取Zend版本：
        //$zend_version = Zend_Version();

        /*$fp = popen('top -b -n 1 | grep -E "(Cpu|Mem|Tasks)"', "r");
        $rs = '';
        while (!feof($fp)) {
            $rs .= fread($fp, 1024);
        }
        pclose($fp);
        $sys_info = explode("\n", $rs);

        $servers = $_SERVER;

        $server_software = $servers['SERVER_SOFTWARE'];
        $server_addr = $servers['SERVER_ADDR'];
        $server_port = $servers['SERVER_PORT'];

        $laravel_version = app()->version();*/

        $data = [];

        $data['metrics']['article_count'] = Post::article()
            ->where('status', '!=', PostStatus::Trash->value)
            ->count('id');
        $data['metrics']['tweet_count'] = Post::tweet()
            ->where('status', '!=', PostStatus::Trash->value)
            ->count('id');
        $data['metrics']['page_count'] = Post::page()
            ->where('status', '!=', PostStatus::Trash->value)
            ->count('id');
        $data['metrics']['comment_count'] = Comment::where('status', CommentStatus::Trash->value)
            ->count('id');

        $data['trend']['posts'] = Post::latest('id')->where('status', PostStatus::Publish->value)->limit(5)->get();
        $data['trend']['comments'] = Comment::with(['post', 'author'])
            ->where('status', '!=', CommentStatus::Trash->value)
            ->where('status', '!=', CommentStatus::Spam->value)
            ->latest('id')->limit(5)->get();

        return view('admin.dashboard.index', compact('data'));
    }
}
