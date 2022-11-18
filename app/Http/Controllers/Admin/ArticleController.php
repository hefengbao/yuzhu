<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Commentable;
use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $query = Post::with(['author', 'tags', 'categories', 'meta'])
            ->withCount(['comments'])
            ->article()
            ->when($user->isAuthor(), function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            });

        $total = $query->clone()->count('id');
        $myTotal = $query->clone()->where('user_id', $user->id)->count('id');
        $pinTotal = $query->clone()->whereNotNull('pinned_at')->count('id');
        $publishTotal = $query->clone()->where('status', 'publish')->count('id');
        $futureTotal = $query->clone()->where('status', 'future')->count('id');
        $pendingTotal = $query->clone()->where('status', 'pending')->count('id');
        $trashTotal = $query->clone()->where('status', 'trash')->count('id');
        $draftTotal = $query->clone()->where('status', 'draft')->count('id');

        $articles = $query->when($request->query('status'), function ($q) use ($request) {
            return $q->where('status', $request->query('status'));
        })->when($request->query('pin'), function ($q) {
            return $q->whereNotNull('pinned_at');
        })->when($request->query('author'), function ($q) use ($request) {
            return $q->where('user_id', $request->query('author'));
        })->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $metrics = [
            'total' => $total,
            'my_total' => $myTotal,
            'publish_total' => $publishTotal,
            'future_total' => $futureTotal,
            'pin_total' => $pinTotal,
            'pending_total' => $pendingTotal,
            'draft_total' => $draftTotal,
            'trash_total' => $trashTotal
        ];

        return view('admin.article.index', compact('articles', 'metrics', 'user'));
    }

    public function store(PostRequest $request)
    {
        $article = new Post();
        $article->author()->associate($request->user());
        $article->title = $request->input('title');
        $article->slug = post_slug($article->title);
        $article->body = $request->input('body');
        $article->excerpt = $request->input('excerpt');
        $article->status = $request->input('status') ?: PostStatus::Draft->value;
        $article->type = PostType::Article->value;
        $article->commentable = $request->input('commentable') ?: Commentable::Open->value;

        if ($request->input('status') == PostStatus::Future->value && $request->input('published_at')) {
            $article->published_at = Carbon::createFromFormat('Y/m/d H:i', $request->input('publish_at'))
                ->format('Y-m-d H:i:s');
        }elseif ($request->input('status') == PostStatus::Draft->value)
            $article->published_at = null;
        else{
            $article->published_at = Carbon::now();
        }

        $article->save();

        if ($request->input('category')) {
            $categoryIds = [];
            foreach ($request->input('category') as $id) {
                $category = Category::find($id);

                if ($category) {
                    $categoryIds[] = $category->id;
                }
            }
            $article->categories()->attach($categoryIds);
        } else {
            $article->categories()->attach(1);
        }

        if ($request->input('tag')) {
            $tagIds = [];
            foreach ($request->input('tag') as $name) {
                $tag = Tag::firstOrCreate([
                    'name' => $name
                ], [
                    'slug' => Str::slug($name, '-', 'zh_CN')
                ]);
                $tagIds[] = $tag->id;
            }
            $article->tags()->attach($tagIds);
        }

        return redirect()->route('admin.articles.index')->with('success', '保存成功');
    }

    public function create()
    {
        $tags = Tag::orderByDesc('id')->get();

        $categories = Category::with(['child'])->whereNull('parent_id')->orderByDesc('id')->get();

        return view('admin.article.create', compact('tags', 'categories'));
    }

    public function edit($id)
    {
        $article = Post::with(['tags', 'categories', 'meta'])->article()->findOrFail($id);

        /** @var User $authUser */
        $authUser = auth()->user();

        if ($authUser->isAuthor() && $article->user_id != $authUser->id) {
            abort(403);
        }

        $tags = Tag::all();

        $categories = Category::with(['child' => function ($q) {
            return $q->with(['child']);
        }])->whereNull('parent_id')->get();

        return view('admin.article.edit', compact('article', 'tags', 'categories'));
    }

    public function destroy($id)
    {
        $article = Post::article()->findOrFail($id);

        $article->update([
            'status' => PostStatus::Trash->value
        ]);

        return redirect()->back()->with('success', '已移到回收站');
    }

    public function update($id, PostRequest $request)
    {
        $article = Post::article()->findOrFail($id);
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->excerpt = $request->input('excerpt');
        $article->status = $request->input('status') ?: PostStatus::Draft->value;
        $article->commentable = $request->input('commentable') ?: Commentable::Open->value;

        if ($request->input('status') == PostStatus::Future->value && $request->input('published_at')) {
            $article->published_at = Carbon::createFromFormat('Y/m/d H:i', $request->input('publish_at'))
                ->format('Y-m-d H:i:s');
        }elseif ($request->input('status') == PostStatus::Draft->value)
            $article->published_at = null;
        else{
            $article->published_at = Carbon::now();
        }

        $article->save();

        if ($request->input('category')) {
            $categoryIds = [];
            foreach ($request->input('category') as $id) {
                $category = Category::find($id);

                if ($category) {
                    $categoryIds[] = $category->id;
                }
            }
            $article->categories()->sync($categoryIds);
        } else {
            $article->categories()->detach();
        }

        if ($request->input('tag')) {
            $tagIds = [];
            foreach ($request->input('tag') as $name) {
                $tag = Tag::firstOrCreate([
                    'name' => $name
                ], [
                    'slug' => Str::slug($name, '-', 'zh_CN')
                ]);
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('admin.articles.index')->with('success', '修改成功');
    }

    public function pin($id)
    {
        /** @var User $authUser */
        $authUser = auth()->user();

        if ($authUser->isAuthor()) {
            abort(403);
        }

        $article = Post::article()->findOrFail($id);

        if ($article->pinned_at) {
            $article->pinned_at = null;
            $message = '置顶成功';
        } else {
            $article->pinned_at = Carbon::now();
            $message = '已取消置顶';
        }
        $article->save();

        return redirect()->back()->with('success', $message);
    }
}
