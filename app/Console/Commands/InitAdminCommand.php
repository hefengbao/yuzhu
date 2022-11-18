<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class AdminInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init';

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
        $admin  =Admin::find(1);

        if ($admin){
            $this->info('已初始化管理员信息，请不要重复操作！');
            return 0;
        }

        $this->info('开始初始化管理员账号，请按提示输入!');

        $name = $this->ask('请输入用户名：');

        $email = $this->ask('请输入邮箱：');

        $password = $this->secret('请输入密码：');
        $confirm_password = $this->secret('请输入确认密码：');

        if ($password != $confirm_password){
            $this->error("确认密码不一致!");
            return 0;
        }

        $admin = new Admin();
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = \Hash::make($password);
        $admin->save();

        $this->info('始化管理员信息结束！');
        return 0;
    }
}
