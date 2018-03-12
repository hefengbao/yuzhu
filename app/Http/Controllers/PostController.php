<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;

class PostController extends Controller
{
    protected $tagRepository;
    protected $categoryRepository;
    protected $postRepository;

    public function __construct(PostRepository $postRepository, TagRepository $tagRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = $this->postRepository->adminPaginate();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = $this->tagRepository->getAll();
        $categories = $this->categoryRepository->getAll();

        return view('admin.post.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->postRepository->save($request->all());

        return redirect('admin/post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tags = $this->tagRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $post = $this->postRepository->findById($id);

        return view('admin.post.edit', compact('post', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request, $id)
    {
        //
        $input = $request->all();
        $this->postRepository->update($id, $input);
        return redirect('admin/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return redirect()->back()->with('success', '删除文章成功！');
    }

    public function uploadImage(Request $request)
    {
        if ($file = $request->file('file')) {
            try {
                $upload_status = app('App\One\Handler\ImageUploadHandler')->uploadImage($file);
            } catch (ImageUploadException $exception) {
                return ['error' => $exception->getMessage()];
            }
            $data['filename'] = $upload_status['filename'];
        } else {
            $data['error'] = 'Error while uploading file';
        }
        return json_encode($data);
    }
}
