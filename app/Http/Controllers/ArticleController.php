<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;


class ArticleController extends Controller
{
    //
    protected $postRepository;
    protected $userRepository;

    public function __construct(PostRepository $postRepository,UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function index($slug){
        $post = $this->postRepository->show($slug);
        $comments = $post->comments;
        foreach ($comments as $comment){
            if ($comment->user_id){
                $user = $this->userRepository->show($comment->user_id);
                $comment->comment_author_avatar = $user->avatar;
            }
        }
        $post->increment('view_count',1);
        $single = true;
        return view('single',compact('post','single','comments'));
    }
}
