<?php

namespace App\Console\Commands;

use App\Constant\PostStatus;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ArticlePublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'one:publish-article';

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

        $articles = Post::article()
            ->where('status', PostStatus::Future->value)
            ->where('published_at', '<=', Carbon::now())
            ->get();

        foreach ($articles as $article) {
            $article->status = PostStatus::Publish->value;
            $article->save();
        }

        return Command::SUCCESS;
    }
}
