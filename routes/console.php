<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// 定时备份
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

// 删除过期的密码重置令牌
Schedule::command('auth:clear-resets')->daily()->at('02:00');

// 每日定时生成站点地图
Schedule::command('yuzhu:sitemap-generate')->daily();
