<?php

namespace App\Console\Commands;

use App\Constant\CMS\CommentStatus;
use App\Constant\CMS\PostStatus;
use App\Constant\CMS\PostType;
use App\Constant\Role;
use App\Models\CMS\Category;
use App\Models\CMS\Post;
use App\Models\FMS\Currency;
use App\Models\FMS\Settings;
use App\Models\Settings\Option;
use App\Models\User;
use App\Services\Finance\SeedCategories;
use Carbon\Carbon;
use Hash;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yuzhu:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化站点';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->initAdmin();

        $this->initPost();

        $this->initFinance();

        return self::SUCCESS;
    }

    private function initAdmin(): void
    {
        $this->info('开始初始化【管理员账号】...');

        $admin = User::find(1);

        if (!$admin) {
            $name = text(
                label: '请输入用户名',
                required: true
            );

            $email = text(
                label: '请输入邮箱',
                required: true
            );

            $password = password(
                label: '请输入密码',
                required: true
            );

            $confirm_password = password(
                label: '请输入确认密码',
                required: true
            );

            if ($password != $confirm_password) {
                $this->error('密码和确认密码不一致!');

                return;
            }

            $bar = $this->output->createProgressBar(1);

            $bar->start();

            $admin = new User();
            $admin->name = $name;
            $admin->email = $email;
            $admin->password = Hash::make($password);
            $admin->role = Role::Administrator;
            $admin->save();

            $bar->finish();

            $this->line('');

            $this->info('一封验证邮件已发送到' . $email . ',请登录邮箱确认！');

            $this->info('初始化【管理员账号】完成。');
        } else {
            $this->info('【管理员账号】已存在，跳过此步骤。');
        }

    }

    private function initPost(): void
    {
        $this->info('开始初始化【内容】模块...');

        $options = [
            [
                'id' => 1,
                'name' => 'title',
                'value' => '玉竹',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'subtitle',
                'value' => '一个简洁的博客、微博客',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'keywords',
                'value' => 'Yuzhu,玉竹,blog,博客,微博客',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'description',
                'value' => '玉竹，一个简洁的博客、微博客。',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'icp',
                'value' => '',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'name' => 'users_can_register',
                'value' => '0',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'name' => 'default_comment_status',
                'value' => CommentStatus::Approved->value,
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'name' => 'site_verify_meta',
                'value' => '',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'name' => 'site_analytics',
                'value' => '',
                'autoload' => 'yes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $categories = [
            [
                'id' => 1,
                'name' => '未分类',
                'slug' => 'uncategorized',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $posts = [
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        $bar = $this->output->createProgressBar(count($options) + count($categories) + count($posts));

        $bar->start();

        DB::transaction(function () use ($options, $categories, $posts) {
            foreach ($options as $option) {
                Option::firstOrCreate(
                    ['id' => $option['id']],
                    $option
                );
            }

            foreach ($categories as $category) {
                Category::firstOrCreate(
                    ['id' => $category['id']],
                    $category
                );
            }

            foreach ($posts as $post) {
                Post::firstOrCreate(
                    ['id' => $post['id']],
                    $post
                );
            }
        }, 3);

        $bar->finish();

        $this->line(''); // 用于换行

        $this->info('初始化【内容】模块完成。');
    }

    private function initFinance(): void
    {
        $this->info('开始初始化【财务】模块...');

        $users = User::with(['financeSettings'])->get();

        $bar = $this->output->createProgressBar($users->count() + 1);

        $bar->start();

        $currency = Currency::firstOrCreate([
            'id' => '1',
            'name' => '人民币',
            'code' => 'CNY',
            'symbol' => '￥',
        ]);

        foreach ($users as $user) {
            if (!$user->financeSettings) {

                DB::transaction(function () use ($currency, $user) {
                    Settings::firstOrcreate([
                        'user_id' => $user->id,
                        'currency_id' => $currency->id
                    ]);

                    (new SeedCategories())->seed($user);
                }, 3);

            }
        }

        $bar->finish();

        $this->line(''); // 用于换行

        $this->info('初始化【财务】模块完成。');
    }
}
