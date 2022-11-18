<?php

namespace App\Console\Commands;

use App\Mail\CheckEmailConfigMail;
use Illuminate\Console\Command;

class CheckEmailConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'one:check-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测邮件是否配置正确';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('开始检测邮件是否配置正确，请按提示输入!');
        $email = $this->ask('请输入邮箱：');
        \Mail::to($email)->send(new CheckEmailConfigMail());
        $this->info('一封邮件已发送到 ' . $email . ',请检查是否收到邮件。');
        return Command::SUCCESS;
    }
}
