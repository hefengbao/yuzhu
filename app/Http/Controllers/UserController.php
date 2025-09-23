<?php

namespace App\Http\Controllers;

use App\Models\CMS\Post;
use App\Models\User;

class UserController extends Controller
{
    public function articles($id)
    {
        $user = User::findOrFail($id);

        $articles = Post::article()
            ->published()
            ->where('user_id', $user->id)
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('themes.default.user.article', compact('user', 'articles'));
    }

    public function tweets($id)
    {
        $user = User::findOrFail($id);

        $tweets = Post::tweet()
            ->published()
            ->where('user_id', $user->id)
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('themes.default.user.tweet', compact('user', 'tweets'));
    }
}
