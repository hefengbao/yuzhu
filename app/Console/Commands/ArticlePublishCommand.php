<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ArticlePublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时发布文章';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
