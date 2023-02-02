<?php

namespace App\Http\Controllers\Admin;

use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $query = Post::page();

        $total = $query->clone()->count('id');
        $publishTotal = $query->clone()->where('status', PostStatus::Publish->value)->count('id');
        $trashTotal = $query->clone()->where('status', PostStatus::Trash->value)->count('id');
        $draftTotal = $query->clone()->where('status', PostStatus::Draft->value)->count('id');

        $pages = $query->when($request->input('status'), function ($q) use ($request) {
            return $q->where('status', $request->input('status'));
        })->orderByDesc('id')->paginate(15);

        $metrics = [
            'total' => $total,
            'publish_total' => $publishTotal,
            'draft_total' => $draftTotal,
            'trash_total' => $trashTotal
        ];

        return view('admin.page.index', compact('pages', 'metrics'));
    }

    public function create()
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        return view('admin.page.create_edit');
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->slug = post_slug($post->title);
        $post->body = $request->input('body');
        $post->excerpt = $request->input('excerpt');
        $post->type = PostType::Page->value;
        $post->status = $request->input('status');
        $post->author()->associate($request->user());
        $post->save();

        return redirect()->route('admin.pages.index')->with('success', '保存成功');
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $page = Post::page()->findOrFail($id);

        return view('admin.page.create_edit', compact('page'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $page = Post::page()->findOrFail($id);

        $page->update([
            'status' => PostStatus::Trash->value
        ]);

        return redirect()->back()->with('success', '已移至回收站');
    }

    public function update($id, PostRequest $request)
    {
        $page = Post::page()->findOrFail($id);

        $page->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'body' => $request->input('body'),
            'excerpt' => $request->input('excerpt'),
            'status' => $request->input('status')
        ]);

        return redirect()->route('admin.pages.index')->with('success', '更新成功');
    }
}
