<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $tweets = Post::with(['author'])->tweet()->select(['id', 'slug', 'body', 'user_id', 'created_at'])
            ->published()
            ->orderByDesc('published_at')
            ->limit(2)
            ->get();
        $articles = Post::article()->select(['id', 'slug', 'title', 'published_at'])
            ->published()
            ->orderByDesc('published_at')
            ->limit(8)
            ->get();

        $pages = Post::page()->published()->select(['id', 'slug', 'title'])->orderByDesc('id')->get();

        return view('themes.default.home', compact('articles', 'tweets', 'pages'));
    }
}
