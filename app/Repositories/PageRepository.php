<?php
/**
 * Author: hefengbao
 * Date: 2016/10/28
 * Time: 14:55
 */

namespace App\Repositories;

use App\Models\Post;
use App\One\Markdown;
use Auth;

class PageRepository
{
    protected $post;
    protected $markdown;
    public function __construct(Post $post, Markdown $markdown)
    {
        $this->post = $post;
        $this->markdown = $markdown;
    }

    public function save($input){
        $input['user_id']=Auth::user()->id;
        $input['category_id'] = 0;
        $input['post_status'] = 1;
        $input['post_type'] = 'page';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']): trim($input['post_excerpt']);
        $post = $this->post->create($input);
        return $post;
    }

    public function update($id,$input){
        $post = $this->post->findOrFail($id);
        $input['user_id']=Auth::user()->id;
        $input['category_id'] = 0;
        $input['post_status'] = 1;
        $input['post_type'] = 'page';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']): trim($input['post_excerpt']);

        if($post->update($input)){
            return redirect()->route('page.index')->with('success','编辑成功');
        }
        else{
            return redirect()->back()->withInput()->withErrors('编辑失败');
        }
    }
    public function adminPaginate(){
        return $this->post->select(Post::postInfo)->latest()->page()->paginate(10);
    }

    public function show($slug){
        $post = $this->post->where('post_slug',$slug)->firstOrFail();
        return $post;
    }
    public function findById($id){
        return $this->post->findOrFail($id);
    }

    public function getAll(){
        return $this->post->select('id','post_title','post_slug')->where('post_type','page')->get();
    }

    public function delete($id){
        $post = $this->post->findOrFail($id);
        return $post->delete();
    }
}