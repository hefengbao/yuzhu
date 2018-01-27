<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

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
        $tags = $this->tagRepository->paginate();
        return view('admin.tag.index', compact('tags'));
    }

    public function store(CreateTagRequest $request)
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
