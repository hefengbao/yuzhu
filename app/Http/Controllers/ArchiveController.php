<?php

namespace App\Http\Controllers;

use App\Models\Post;

class ArchiveController extends Controller
{
    public function index()
    {
        $posts = Post::published()->orderByDesc('id')->paginate(20);

        return view('themes.default.archive.index', compact('posts'));
    }
}
