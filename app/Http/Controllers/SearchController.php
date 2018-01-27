<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Purifier;

class SearchController extends Controller
{
    //

    public function index(Request $request)
    {
        $query = Purifier::clean($request->input('q'), 'search_q');
        $posts = Post::search($query)->paginate(20);
        return view('search', compact('posts', 'query'));
    }

}
