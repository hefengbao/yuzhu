<?php

if (!function_exists('make_excerpt')) {
    function make_excerpt($html): string
    {
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return Str::limit($excerpt, 200);
    }
}


if (!function_exists('categories_to_str')) {
    function categories_to_str(\Illuminate\Database\Eloquent\Collection $categories, bool $withLink = true): ?string
    {
        if ($categories->isNotEmpty()) {
            $arr = [];
            foreach ($categories as $category) {
                if ($withLink) {
                    $arr[] = '<a href="' . route("search.categories", $category->slug) . '" target="_blank">' . $category->name . '</a>';
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
    function tags_to_str(\Illuminate\Database\Eloquent\Collection $tags, bool $withLink = true): ?string
    {
        if ($tags->isNotEmpty()) {
            $arr = [];
            foreach ($tags as $tag) {
                if ($withLink) {
                    $arr[] = '<a href="' . route("search.tags", $tag->slug) . '" target="_blank">' . $tag->name . '</a>';
                } else {
                    $arr[] = $tag->name;
                }
            }

            return Arr::join($arr, '、');
        }

        return null;
    }
}

if (!function_exists('post_slug')){
    function post_slug($title){
        return \Str::slug($title, '-','zh_CN').'-'.\Str::lower(\Str::random());
    }
}
