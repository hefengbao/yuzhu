<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Cache;

class TagService
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getAll()
    {
        return Cache::remember('tags', 30, function () {
            return $this->tag->all();
        });
    }

    public function save($input)
    {
        return $this->tag->firstOrCreate($input);
        Cache::forget('tags');
    }

    public function getTagbyName($name)
    {
        return $this->tag->where('tag_name', '=', $name)->firstOrFail();
    }

    public function getPostGroupByTag(Tag $tag)
    {
        return $tag->posts()->select(Post::list)->paginate(10);
    }

    public function paginate()
    {
        return $this->tag->paginate(20);
    }
}
