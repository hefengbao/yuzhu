<?php

namespace App\Console\Commands;

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
    protected $signature = 'yuzhu:sitemap-generate';

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

        $posts = Post::article()
            ->published()
            ->orderByDesc('id')
            ->get();

        foreach ($posts as $post) {
            $creator->add(
                Url::create(route('articles.show', $post->slug_id))
                    ->setLastModificationDate(max($post->updated_at, $post->published_at))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                    ->setPriority(0.8)
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
