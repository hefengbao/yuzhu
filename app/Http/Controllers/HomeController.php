<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $post = Post::findOrFail(1);

        return view('themes.default.home', compact('post'));
    }
}
