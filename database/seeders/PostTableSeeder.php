<?php

namespace Database\Seeders;

use App\Constant\PostStatus;
use App\Constant\PostType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        DB::table('posts')->insert([
            [
                'id' => 1,
                'slug' => 'about',
                'user_id' => 1,
                'title' => '关于',
                'body' => '<!--简单示例--->
<!--站点标题、站长用户名等-->
<h1>玉竹</h1>
<!--站点副标题、站长介绍等-->
<p>
	简洁的博客、微博客系统
</p>
<!--站点描述、其他说明-->
<p>
	对微博客的一点说明，有时想写点的什么但是又没有一个贴合的标题，可能因此又不想写了，于是做了一个小的模块，就像发微博那样，只写内容就可以了。显示的时候也是单独的一块。
</p>
<!--格言、座右铭之类-->
<blockquote>
 如果你感觉自己被困住了，焦虑并充满消极情绪，生命出现了停滞，那么治疗方法很简单：做点什么。
  <footer>
    <cite>— 《摆脱束缚的最好方法》</cite>
  </footer>
</blockquote>

<!--链接-->
<div class="grid">
	<!--Github-->
	<a class="contrast" data-discover="true" href="https://github.com/hefengbao" target="_blank">
		Github
	</a>
	<!--微博-->
	<a class="contrast" data-discover="true" href="https://weibo.com/u/6698759239" target="_blank">
		微博
	</a>
	<!--微信-->
	<a class="contrast" data-discover="true" href="https://hefengbao.github.io/assets/images/NowInLife.png" target="_blank">
		微信公众号
	</a>
	<!--B站-->
	<a class="contrast" data-discover="true" href="https://space.bilibili.com/34255662" target="_blank">
		B 站
	</a>
</div>',
                'type' => PostType::Page->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'slug' => 'privacy',
                'user_id' => 1,
                'title' => '隐私政策',
                'body' => '## 我们是谁
我们的站点地址是：http://yuzhu.test。
## 评论
当访客留下评论时，我们会收集评论表单所显示的数据（包括用户名、邮箱地址和评论内容），和访客的IP地址及浏览器的user agent字符串来帮助检查垃圾评论。
## 媒体
如果您向此网站上传图片，您应当避免上传那些有嵌入地理位置信息（EXIF GPS）的图片。此网站的访客将可以下载并提取此网站的图片中的位置信息。
## Cookies
如果您在我们的站点上留下评论，您可以选择用cookies保存您的用户名、电子邮箱地址，这样您在下次使用时不用重复填写相关信息。
当您登录时，我们也会设置 cookies 来保存您的登录信息。登录 cookies 会保留两小时。如果您选择了“记住我”，您的登录状态则会保留两周。如果您注销登陆了您的账户，用于登录的cookies将会被移除。
## 来自其他网站的嵌入内容
此站点上的文章可能会包含嵌入的内容（如视频、图片、文章等）。来自其他站点的嵌入内容的行为和您直接访问这些其他站点没有区别。
这些站点可能会收集关于您的数据、使用cookies、嵌入额外的第三方跟踪程序及监视您与这些嵌入内容的交互，包括在您有这些站点的账户并登录了这些站点时，跟踪您与嵌入内容的交互。
## 我们保留多久您的信息
如果您留下评论，评论和其元数据将被无限期保存。
对于本网站的注册用户，我们也会保存用户在个人资料中提供的个人信息，以及您在本站发布的内容。
## 说明
参考 Wordpress 写的 😄， 站长可自行修改。',
                'type' => PostType::Page->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'slug' => 'first-post',
                'user_id' => 1,
                'title' => '示例文章',
                'body' => '这世界我来了！',
                'type' => PostType::Article->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
