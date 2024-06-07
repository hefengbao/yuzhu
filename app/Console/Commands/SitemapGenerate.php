<?php

namespace App\Console\Commands;

use App\Constant\PostType;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成站点地图';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $creator = Sitemap::create();

        $posts = Post::whereNotNull('published_at')
            ->where('published_at','<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->orderByDesc('id')
            ->get();

        foreach ($posts as $post) {
            $url = match ($post->type) {
                PostType::Tweet->value => '/tweets/' . $post->slug_id,
                PostType::Article->value => '/articles/' . $post->slug_id,
                PostType::Page->value => '/pages/' . $post->slug_id,
            };

            $priority = match ($post->type) {
                PostType::Tweet->value => 0.1,
                PostType::Article->value => 0.8,
                PostType::Page->value => 0.6,
            };

            $frequency = match ($post->type) {
                PostType::Tweet->value => Url::CHANGE_FREQUENCY_YEARLY,
                PostType::Article->value => Url::CHANGE_FREQUENCY_WEEKLY,
                PostType::Page->value => Url::CHANGE_FREQUENCY_MONTHLY,
            };

            $creator->add(
                Url::create($url)
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency($frequency)
                    ->setPriority($priority)
            );
        }

        $creator->add(
            Url::create('/search')
                ->setLastModificationDate(Carbon::today())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.4)
        )
            ->add(
                Url::create('/')
                    ->setLastModificationDate(Carbon::today())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

        $creator->writeToFile(public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}
