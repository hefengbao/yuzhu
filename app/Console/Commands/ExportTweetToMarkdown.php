<?php

namespace App\Console\Commands;

use App\Enums\CMS\PostType;
use App\Models\CMS\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('app:export-tweet-to-markdown')]
#[Description('微博导出为 Markdown 文件')]
class ExportTweetToMarkdown extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tweets = Post::where('type', PostType::Tweet)->orderBy('id')->get();
        $year_tweets = $tweets->groupBy(function ($item) {
            return $item->created_at->format('Y');
        });

        foreach ($year_tweets as $year => $tweets) {
            $str = "# $year" . PHP_EOL;
            $str .= PHP_EOL;
            foreach ($tweets as $tweet) {
                $datetime = $tweet->created_at->format('Y-m-d H:i:s');
                $weekday = date('w', strtotime($datetime));
                $str .= "## $datetime $weekday" . PHP_EOL;
                $str .= $tweet->body . PHP_EOL;
                $str .= PHP_EOL;
            }
            Storage::put('export/tweet/' . $year . '.md', $str);
            $this->info($year . '.md');
        }
    }
}
