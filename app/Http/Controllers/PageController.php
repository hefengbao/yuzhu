<?php

namespace App\Http\Controllers;

use App\Models\Post;
use GrahamCampbell\Markdown\Facades\Markdown;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Post::page()->where('slug', $slug)->firstOrFail();
        $page->body = Markdown::convert($page->body)->getContent();

        return view('themes.default.page.show', compact('page'));
    }
}
