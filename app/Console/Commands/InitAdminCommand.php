<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;

class InitAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'one:init-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化管理员';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = User::find(1);

        if ($admin) {
            $this->info('已初始化管理员信息，请不要重复操作！');
            return Command::SUCCESS;
        }

        $this->info('开始初始化管理员账号，请按提示输入!');

        $name = $this->ask('请输入用户名：');

        $email = $this->ask('请输入邮箱：');

        $password = $this->secret('请输入密码：');
        $confirm_password = $this->secret('请输入确认密码：');

        if ($password != $confirm_password) {
            $this->error("确认密码不一致!");
            return Command::INVALID;
        }

        $admin = new User();
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = \Hash::make($password);
        $admin->role = 'administrator';
        $admin->save();

        event(new Registered($admin));

        $this->info('一封验证邮件已发送到' . $email . ',请登录邮箱确认！');

        $this->info('始化管理员信息结束！');

        return Command::SUCCESS;
    }
}
