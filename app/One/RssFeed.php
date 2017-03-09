<?php
/**
 * Author: hefengbao
 * Date: 2017/1/11
 * Time: 11:22
 */

namespace App\One;

use App\Models\Post;
use App\Repositories\OptionRepository;
use Carbon\Carbon;
use Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
    protected $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function getFeed(){
        if(Cache::has('rss-feed')){
            return Cache::get('rss-feed');
        }

        $rss = $this->buildRssData();
        Cache::add('rss-feed',$rss,120);

        return $rss;
    }

    private function buildRssData()
    {
        $option = $this->optionRepository->getAll();
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel->title($option['title'])
            ->description($option['description'])
            ->url(url('/'))
            ->language('en')
            ->copyright('Copyright (c)'. url('/'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $posts = Post::select(Post::postInfo)
            ->published()
            ->orderBy('published_at','desc')
            ->take(20)
            ->get();

        foreach ($posts as $post){
            $item = new Item();
            $item->title($post->post_title)
                ->description($post->post_excerpt)
                ->url(url('article/'.$post->post_slug))
                ->pubDate($post->published_at->timestamp)
                ->appendTo($channel);
        }

        $feed = (string)$feed;
        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>'."\n".'    <atom:link href="'.url('/feed').'" rel="self" type="application/rss+xml" />',
            $feed
        );return $feed;
    }

}