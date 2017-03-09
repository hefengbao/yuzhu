<?php
/**
 * Author: hefengbao
 * Date: 2016/11/10
 * Time: 14:31
 */

namespace App\Http\ViewComposers;


use App\Repositories\PostRepository;
use Illuminate\View\View;

class HotTopicComposer
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function compose(View $view){
        $hotTopics = $this->postRepository->hotTopic();
        $view->with('hotTopics',$hotTopics);
    }
}