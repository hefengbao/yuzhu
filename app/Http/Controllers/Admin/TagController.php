<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $tags = Tag::orderByDesc('id')->get();

        return view('admin.tag.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        Tag::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug') ?? $request->input('name'),
        ]);

        return redirect()->route('admin.tags.index')->with('success', '添加标签成功');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.tag.edit', compact('tag'));
    }

    public function update($id, TagRequest $request)
    {
        $tag = Tag::findOrFail($id);

        $tag->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        return redirect()->route('admin.tags.index')->with('success', '更新标签成功');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        \DB::transaction(function () use ($tag, $id) {
            \DB::table('post_tag')->where('tag_id', $id)->delete();

            $tag->delete();
        }, 3);

        return redirect()->route('admin.tags.index')->with('success', '删除标签成功');
    }
}
