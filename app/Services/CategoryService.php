<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Cache;

class CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return Cache::remember('categories', 30, function () {
            return $this->category->get();
        });
    }

    public function getCategoryById($id)
    {
        return $this->category->findOrFail($id);
    }

    public function getCategoryBySlug($slug)
    {
        return $this->category->where('category_slug', '=', $slug)->first();
    }

    public function getPostGroupByCategory(Category $category)
    {
        return $category->posts()->select(Post::list)->paginate(10);
    }

    public function paginate()
    {
        return $this->category->paginate(20);
    }

    public function save($data)
    {
        Cache::forget('categories');

        return $this->category->firstOrCreate($data);
    }
}
