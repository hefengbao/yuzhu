<?php

namespace App\Services;

use App\Models\Post;
use App\One\Markdown;
use Auth;
use Cache;
use function App\Repositories\array_has;

class PostService
{
    protected $post;

    protected $tagRepository;

    protected $categoryRepository;

    protected $markdown;

    public function __construct(Post            $post, TagService $tagRepository, Markdown $markdown,
                                CategoryService $categoryRepository)
    {
        $this->post = $post;
        $this->tagRepository = $tagRepository;
        $this->markdown = $markdown;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, $input)
    {
        $post = $this->post->findOrFail($id);

        $input['user_id'] = Auth::user()->id;
        $input['category_id'] = $input['post_category'];
        $input['post_type'] = 'post';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']) : makeExcerpt(trim($input['post_excerpt']));

        $tag_ids = [];
        if (array_has($input, 'tags')) {
            $tags = $input['tags'];
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    $tagInfo = $this->tagRepository->save(['tag_name' => $tag]);
                    array_push($tag_ids, $tagInfo->id);
                }
            }
        }
        $post->update($input);
        $post->tags()->sync($tag_ids);

        return $post;
    }

    /**
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function save($input)
    {
        $str = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm';
        $input['post_slug'] = $input['post_slug'] . '-' . substr(str_shuffle($str), 5, 8);
        $input['user_id'] = Auth::user()->id;
        $input['category_id'] = $input['post_category'];
        $input['post_type'] = 'post';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']) : makeExcerpt(trim($input['post_excerpt']));
        $post = $this->post->create($input);

        $category = $this->categoryRepository->getCategoryById($input['category_id']);
        Cache::forget('categories');
        $category->increment('count', 1);
        $tag_ids = [];
        if (array_has($input, 'tags')) {
            $tags = $input['tags'];
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    $tagInfo = $this->tagRepository->save(['tag_name' => $tag]);
                    array_push($tag_ids, $tagInfo->id);
                }
            }
        }
        $post->tags()->attach($tag_ids);

        return $post;
    }

    /**
     * 管理员界面显示
     *
     * @return mixed
     */
    public function adminPaginate()
    {
        if (Auth::user()->hasRole('admin')) {//管理员，获取所有文章
            $posts = $this->post->select(Post::selectField)->post()->latest('id')->paginate(10);
        } else {//普通用户，获取当前用户文章
            $posts = $this->post->select(Post::selectField)->post()->currentUser()->latest('id')->paginate(10);
        }

        return $posts;
    }

    /**
     * 首页显示
     *
     * @return mixed
     */
    public function paginate()
    {
        $posts = $this->post->select(Post::selectField)->published()->latest('published_at')->paginate(10);

        return $posts;
    }

    /**
     *根据slug获取文章
     *
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function show($slug)
    {
        $post = $this->post->with(['user'])->where('post_slug', $slug)->firstOrFail();

        return $post;
    }

    /**根据ID获取文章
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $post = $this->post->findOrFail($id);
    }

    /**热门文章
     * @return mixed
     */
    public function hotTopic()
    {
        $data = Cache::remember('hotTopic', 60 * 24, function () {
            return $this->post
                ->select('post_title', 'post_slug')
                ->where('post_type', 'post')
                ->orderBy('view_count', 'desc')
                ->limit(10)
                ->get();
        });

        return $data;
    }

    public function archive()
    {
        $data = $this->post->select('post_title', 'post_slug', 'published_at')
            ->published()
            ->orderBy('published_at', 'desc')
            ->get();

        return $data;
    }

    public function delete($id)
    {
        $post = $this->post->findOrFail($id);

        return $post->delete();
    }
}
