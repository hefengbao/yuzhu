<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    //
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        if(!Gate::allows('tag.index')){
            abort(401);
        }
        $tags = $this->tagRepository->paginate();
        return view('admin.tag.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        $this->tagRepository->save($request->except('_token'));
        return redirect()->route('tag.index')->with('success', '添加标签成功');
    }

    public function posts($name)
    {
        $tag = $this->tagRepository->getTagbyName($name);
        $posts = $this->tagRepository->getPostGroupByTag($tag);
        return view('tag', compact('posts', 'name'));
    }

}
