<?php

namespace App\Http\Controllers;

use App\Models\Post;
use GrahamCampbell\Markdown\Facades\Markdown;

class PageController extends Controller
{
    public function show($slugId)
    {
        $id = extract_id($slugId);
        $page = Post::page()->findOrFail($id);
        $page->body = Markdown::convert($page->body)->getContent();

        return view('themes.default.page.show', compact('page'));
    }
}
