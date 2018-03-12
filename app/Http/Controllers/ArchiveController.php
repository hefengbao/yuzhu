<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

class ArchiveController extends Controller
{
    //
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $data = $this->postRepository->archive();
        return view('archives', compact('data'));
    }
}
