<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Auth;


class ArticleController extends Controller
{
    //
    protected $postRepository;
    protected $userRepository;
    protected $post;

    public function __construct(PostRepository $postRepository,UserRepository $userRepository,Post $post)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->post = $post;
    }

    public function index($slug){
        $post = $this->postRepository->show($slug);
        $pre_id = $this->getPrevArticleId($post->id);
        $next_id = $this->getNextArticleId($post->id);
        $pre = $this->post->select(['post_title','post_slug'])->where('id',$pre_id)->first();
        $next = $this->post->select(['post_title','post_slug'])->where('id',$next_id)->first();
        $comments = $post->comments;
        foreach ($comments as $comment){
            if ($comment->user_id){
                $user = $this->userRepository->show($comment->user_id);
                $comment->comment_author_avatar = $user->avatar;
            }
        }
        if (!Auth::check()){
            $post->increment('view_count',1);
        }
        $single = true;
        return view('single',compact('post','single','pre','next','comments'));
    }

    protected function getPrevArticleId($id){
        return $this->post->published()->where('id', '<', $id)->max('id');
    }
    protected function getNextArticleId($id){
        return $this->post->published()->where('id', '>', $id)->min('id');
    }
}
