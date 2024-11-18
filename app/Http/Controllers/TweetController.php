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

    public function show($slugId)
    {
        $id = extract_id($slugId);

        $tweet = Post::with(['author', 'tags'])->tweet()->findOrFail($id);

        return view('themes.default.tweet.show', compact('tweet'));
    }
}
