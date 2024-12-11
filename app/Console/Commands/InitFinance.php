<?php

namespace App\Console\Commands;

use App\Models\Finance\Currency;
use App\Models\Finance\Settings;
use App\Models\User;
use App\Services\Finance\SeedCategories;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitFinance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yuzhu:init-finance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化【财务】模块';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $currency = Currency::firstOrCreate([
            'id' => '1',
            'name' => '人民币',
            'code' => 'CNY',
            'symbol' => '￥',
        ]);

        $users = User::with(['financeSettings'])->get();

        $bar = $this->output->createProgressBar($users->count());

        $bar->start();

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

        $this->info("初始化【财务】模块结束。");

        return self::SUCCESS;
    }
}
