<?php

namespace App\Http\Controllers;

use App\Models\CMS\Category;
use App\Models\CMS\Tag;

class SearchController extends Controller
{
    public function index()
    {
        $tags = Tag::orderByDesc('id')->get();
        $categories = Category::orderByDesc('id')->get();

        return view('themes.default.search.index', compact('categories', 'tags'));
    }

    public function categories($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()->with(['categories'])->paginate(20);

        return view('themes.default.search.category', compact(['posts', 'category']));
    }

    public function tags($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()->with(['tags'])->paginate(20);

        return view('themes.default.search.tag', compact(['posts', 'tag']));
    }
}
