<?php

namespace Database\Seeders;

use App\Constant\PostStatus;
use App\Constant\PostType;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('posts')->insert([
            [
                'id' => 1,
                'slug' => 'about',
                'user_id' => 1,
                'title' => '关于',
                'body' => '{"time":1668151746050,"blocks":[{"id":"RYSuNc58Wx","type":"paragraph","data":{"text":"One 是一个简介的博客，微博客系统。"}},{"id":"7mtmnlUm4c","type":"paragraph","data":{"text":"对微博客的一点说明，有时想写点的什么但是又没有一个贴合的标题，可能因此又不想写了，于是做了一个小的模块，就像发微博那样，只写内容就可以了。显示的时候也是单独的一块。"}},{"id":"91OCPvNVyE","type":"paragraph","data":{"text":"项目地址：<a href=\"https://github.com/hefengbao/one\">hefengbao/one: 一个简洁的博客、微博客。 (github.com)</a>"}},{"id":"mA33qseKsj","type":"paragraph","data":{"text":"微博：<a href=\"https://www.weibo.com/u/1778629642\">@_好安静</a>、<a href=\"https://weibo.com/u/6698759239\">@Eyeswap</a>"}},{"id":"ndO_JU7ghG","type":"paragraph","data":{"text":"微信公众号：<a href=\"https://hefengbao.github.io/assets/images/eyeswap.jpg\">Eyeswap</a>"}}],"version":"2.25.0"}',
                'type' => PostType::Page->value,
                'status' => PostStatus::Publish->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'slug' => 'privacy',
                'user_id' => 1,
                'title' => '隐私政策',
                'body' => '{"time":1668065153770,"blocks":[{"id":"nD3CwUIyvo","type":"header","data":{"text":"我们是谁","level":3}},{"id":"1TbXSFzk6N","type":"paragraph","data":{"text":"我们的站点地址是：http://one.test。"}},{"id":"dyxiIVIR8c","type":"header","data":{"text":"评论","level":3}},{"id":"z5N13KchVd","type":"paragraph","data":{"text":"当访客留下评论时，我们会收集评论表单所显示的数据（包括用户名、邮箱地址和评论内容），和访客的IP地址及浏览器的user agent字符串来帮助检查垃圾评论。"}},{"id":"OJk178i0__","type":"header","data":{"text":"媒体","level":3}},{"id":"aurpVOPcrP","type":"paragraph","data":{"text":"如果您向此网站上传图片，您应当避免上传那些有嵌入地理位置信息（EXIF GPS）的图片。此网站的访客将可以下载并提取此网站的图片中的位置信息。"}},{"id":"9CO2BEjCTK","type":"header","data":{"text":"Cookies","level":3}},{"id":"-JNqkUMnQf","type":"paragraph","data":{"text":"如果您在我们的站点上留下评论，您可以选择用cookies保存您的用户名、电子邮箱地址，这样您在下次使用时不用重复填写相关信息。"}},{"id":"iAqLSO2L3q","type":"paragraph","data":{"text":"当您登录时，我们也会设置 cookies 来保存您的登录信息。登录 cookies 会保留两小时。如果您选择了“记住我”，您的登录状态则会保留两周。如果您注销登陆了您的账户，用于登录的cookies将会被移除。"}},{"id":"myDHsjyz-o","type":"header","data":{"text":"来自其他网站的嵌入内容","level":3}},{"id":"NVk9PXG3eo","type":"paragraph","data":{"text":"此站点上的文章可能会包含嵌入的内容（如视频、图片、文章等）。来自其他站点的嵌入内容的行为和您直接访问这些其他站点没有区别。"}},{"id":"XQD4lDxtcw","type":"paragraph","data":{"text":"这些站点可能会收集关于您的数据、使用cookies、嵌入额外的第三方跟踪程序及监视您与这些嵌入内容的交互，包括在您有这些站点的账户并登录了这些站点时，跟踪您与嵌入内容的交互。"}},{"id":"Y_zG8zmeIk","type":"header","data":{"text":"我们保留多久您的信息","level":3}},{"id":"YnNQ4yz5Od","type":"paragraph","data":{"text":" 如果您留下评论，评论和其元数据将被无限期保存。"}},{"id":"jEOaIGx4DM","type":"paragraph","data":{"text":"对于本网站的注册用户，我们也会保存用户在个人资料中提供的个人信息，以及您在本站发布的内容。"}},{"id":"d_2q6XdBXa","type":"warning","data":{"title":"说明","message":"参考 Wordpress 写的,&nbsp; 😄， 站长可自行修改。"}}],"version":"2.25.0"}',
                'type' => PostType::Page->value,
                'status' => PostStatus::Publish->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'slug' => 'first-post',
                'user_id' => 1,
                'title' => '示例文章',
                'body' => '{"time":1668066829060,"blocks":[{"id":"Q3AwKuYT6u","type":"paragraph","data":{"text":"写一下编辑器的使用说明吧。"}},{"id":"qcCWOClzgX","type":"header","data":{"text":"一、段落","level":2}},{"id":"x0AVqwNFh8","type":"paragraph","data":{"text":"默认为段落。其他如标题、列表、表格等，可点击前边的<b><mark class=\"cdx-marker\">+</mark></b>&nbsp;号选择，或者选中已有的内容，在弹出的菜单中选择转换。"}},{"id":"iiZhK-8qxi","type":"header","data":{"text":"二、标题","level":2}},{"id":"V6P7URyQ5X","type":"paragraph","data":{"text":"标题有4级可选（在详细页文章标题显示为一级标题，故不允许选用一级标题），默认为二级："}},{"id":"HrEHRIz07B","type":"header","data":{"text":"这是二级标题！","level":3}},{"id":"DF8mkoTbhq","type":"header","data":{"text":"这是三级标题！","level":3}},{"id":"Lbn9eDCVwe","type":"header","data":{"text":"这是四级标题！","level":4}},{"id":"GA1SFUox6Z","type":"header","data":{"text":"这是五级标题！","level":5}},{"id":"7wizgkEmzb","type":"header","data":{"text":"三、引用","level":2}},{"id":"KZEuNmcZra","type":"quote","data":{"text":"世上本没有路，走的人多了便有了路！","caption":"鲁迅","alignment":"left"}},{"id":"m1iealNE-D","type":"header","data":{"text":"四、分割线","level":2}},{"id":"lnotse3s0S","type":"delimiter","data":{}},{"id":"1Ob9QKD7ko","type":"header","data":{"text":"五、列表","level":2}},{"id":"Q5le_zjEHm","type":"paragraph","data":{"text":"列表分为有序列表和无序列表。"}},{"id":"qbaI03E7f0","type":"paragraph","data":{"text":"有序列表:"}},{"id":"UFuW-C4P9r","type":"list","data":{"style":"ordered","items":["第一小节；","第二小节。"]}},{"id":"qHxSqJHO62","type":"paragraph","data":{"text":"无序列表："}},{"id":"D_6MLv3NvP","type":"list","data":{"style":"unordered","items":["第一小节；","第二小节。"]}},{"id":"71iFubBC-F","type":"paragraph","data":{"text":"无序列表有点bug，不是很好用。"}},{"id":"5Wzq06swfm","type":"header","data":{"text":"六、清单","level":2}},{"id":"kJLwUAyOme","type":"checklist","data":{"items":[{"text":"清单一，已完成","checked":true},{"text":"清单二，未完成","checked":false}]}},{"id":"p4LpMrzfqu","type":"header","data":{"text":"七、警告","level":2}},{"id":"hy84Lqcgkr","type":"warning","data":{"title":"注意事项","message":"请注意，这里有🐍出没。"}},{"id":"LETMM7Uvza","type":"header","data":{"text":"八、代码","level":2}},{"id":"GkgnsrZKuk","type":"code","data":{"code":"<php\n  echo \'Hello world\';\n?>"}},{"id":"waxB3vpCfV","type":"header","data":{"text":"九、链接","level":2}},{"id":"YY2phhO6N_","type":"paragraph","data":{"text":"在输入框里输入链接地址（应添加 https 或 http），或者把复制的地址粘贴到输入框，链接解析成功，则会显示为一个卡片，如果输入框显示为谈红色，则链接解析失败。"}},{"id":"zovDKlcyP2","type":"linkTool","data":{"link":"https://github.com/hefengbao/one","meta":{"title":"GitHub - hefengbao/one: 一个简洁的博客、微博客。","description":"一个简洁的博客、微博客。. Contribute to hefengbao/one development by creating an account on GitHub.","image":{"url":""}}}},{"id":"UPoX7qm-Vd","type":"header","data":{"text":"十、表格","level":2}},{"id":"y1NyLik-vd","type":"paragraph","data":{"text":"默认没有表头，可选择转化:"}},{"id":"7-0uL9BW4S","type":"table","data":{"withHeadings":false,"content":[["序号","姓名"],["1","张三"],["2","李四"]]}},{"id":"MlMDpExT3I","type":"header","data":{"text":"十一、图片","level":2}},{"id":"wZ3ZxaZxCK","type":"paragraph","data":{"text":"上传图片。"}}],"version":"2.25.0"}',
                'type' => PostType::Article->value,
                'status' => PostStatus::Publish->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
