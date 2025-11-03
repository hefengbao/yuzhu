<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('make_excerpt')) {
    function make_excerpt($html): string
    {
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));

        return Str::limit($excerpt, 160);
    }
}

if (!function_exists('categories_to_str')) {
    function categories_to_str(Collection $categories, bool $withLink = true): ?string
    {
        if ($categories->isNotEmpty()) {
            $arr = [];
            foreach ($categories as $category) {
                if ($withLink) {
                    $arr[] = '<a href="' . route('search.categories', $category->slug) . '" target="_blank">' . $category->name . '</a>';
                } else {
                    $arr[] = $category->name;
                }
            }

            return Arr::join($arr, '、');
        }

        return null;
    }
}

if (!function_exists('tags_to_str')) {
    function tags_to_str(Collection $tags, bool $withLink = true): ?string
    {
        if ($tags->isNotEmpty()) {
            $arr = [];
            foreach ($tags as $tag) {
                if ($withLink) {
                    $arr[] = '<a href="' . route('search.tags', $tag->slug) . '" target="_blank">' . $tag->name . '</a>';
                } else {
                    $arr[] = $tag->name;
                }
            }

            return Arr::join($arr, '、');
        }

        return null;
    }
}

if (!function_exists('post_slug')) {
    function post_slug($title)
    {
        // TODO 翻译
        return Str::slug($title, '-', 'zh_CN');
    }
}

if (!function_exists('slug_id')) {
    function slug_id(string $slug, int $id): string
    {
        return $slug . '-' . Hashids::connection('one')->encode($id);
    }
}

if (!function_exists('extract_id')) {
    function extract_id($str): int
    {
        $arr = explode('-', $str);

        abort_if(count($arr) == 0, 404, '您访问的页面不存在 /(ㄒoㄒ)/~~');

        $ids = Hashids::connection('one')->decode($arr[count($arr) - 1]);

        abort_if(count($ids) == 0, 404, '您访问的页面不存在 /(ㄒoㄒ)/~~');

        return $ids[0];
    }
}
