<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;

class HomeController2 extends Controller
{
    protected $postRepository;

    public function __construct(PostService $postRepository)
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

    public function export()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $tag = '';
            if ($post->tags) {
                foreach ($post->tags as $tag) {
                    $tag .= $tag->tag_name . ',';
                }
            }

            if (strlen($tag)) {
                $tag = substr($tag, 0, strlen($tag) - 1);
            }
            $str = '---\n';
            $str .= "title: $post->post_title\n";
            $str .= "date: $post->created_at\n";
            $str .= "updated: $post->updated_at\n";
            $str .= "tags: $tag.\n";
            $str .= "categories: $post->category->category_name.\n";
            $str .= "permalink: $post->post_slug.\n";
            $str .= '---\n';
            $str .= $post->post_content;
            file_put_contents(storage_path('export/' . date('Ymd', strtotime($post->created_at)) . '-' . implode('-', explode(' ', $post->post_title)) . '.txt'), $str, FILE_APPEND);
        }

    }
}
