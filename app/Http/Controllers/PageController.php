<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Post::page()->where('slug', $slug)->firstOrFail();

        return view('themes.default.page.show', compact('page'));
    }
}
