<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

class HomeController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->paginate();
        return view('home', compact('posts'));
    }
}
