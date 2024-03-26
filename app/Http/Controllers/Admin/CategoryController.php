<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $categories = Category::with(['child'])->whereNull('parent_id')->orderByDesc('id')->get();

        return view('admin.category.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $request->input('parent'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', '添加成功');
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $categories = Category::whereNull('parent_id')->orderByDesc('id')->get();

        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('categories', 'category'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $category = Category::findOrFail($id);

        $children = Category::where('parent_id', $id)->get();

        $childrenIds = $children->pluck('id')->toArray();

        $ids = array_merge($childrenIds, [$id]);

        \DB::transaction(function () use ($ids, $category) {
            \DB::table('category_post')->whereIn('category_id', $ids)->update([
                'category_id' => 1,
            ]);

            $category->delete();
        }, 3);

        return redirect()->route('admin.categories.index')->with('success', '删除成功');
    }

    public function update($id, CategoryRequest $request)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $request->input('parent'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', '删除成功');
    }
}
