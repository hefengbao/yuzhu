<?php

namespace App\Http\Controllers;

use App\Models\Post;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Post::with(['author'])
            ->tweet()
            ->published()
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('themes.default.tweet.index', compact('tweets'));
    }

    public function show($slug)
    {
        $tweet = Post::with(['author', 'tags'])->tweet()->where('slug', $slug)->firstOrFail();

        return view('themes.default.tweet.show', compact('tweet'));
    }
}
