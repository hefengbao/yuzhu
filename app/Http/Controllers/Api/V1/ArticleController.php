<?php

namespace App\Http\Controllers\Api\V1;

use App\Constant\Post\Commentable;
use App\Constant\Post\PostStatus;
use App\Constant\Post\PostType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(Request $request): JsonResponse
    {
        $articles = Post::with([
            'author',
            'categories',
            'tags',
        ])->article()
            ->when($request->query('key'), function ($query) use ($request) {
                $query->where('id', '<', $request->query('key'));
            })
            ->limit($request->query('page_size', 10))
            ->orderByDesc('id')
            ->get();

        return PostResource::collection($articles)->response()
            ->header('Cache-Control', 'public, max-age=3600')
            ->setEtag(md5($articles->pluck('id')->join(', ')));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
            'excerpt' => 'required|string',
            'commentable' => 'nullable|string',
            'status' => 'required|string',
            'published_at' => [
                'required_if:status,' . PostStatus::Published->value,
                'string'
            ],
            'tags' => 'nullable|array',
            'categories' => 'nullable|array',
        ]);

        $article = new Post();
        $article->title = $request->input('title');
        $article->slug = $request->input('slug', Str::slug($request->input('title')));
        $article->body = $request->input('body');
        $article->excerpt = $request->input('excerpt');
        $article->type = PostType::Article;
        $article->commentable = $request->input('commentable', Commentable::Open);
        $article->status = $request->input('status', PostStatus::Draft);
        $article->published_at = $request->input('published_at');
        $article->author()->associate($request->user());
        $article->save();

        $categories = Category::find($request->input('categories', [1]));

        if ($categories->isNotEmpty()) {
            $article->categories()->attach($categories);
        }

        $tags = Tag::find($request->input('tags', []));

        if ($tags->isNotEmpty()) {
            $article->tags()->attach($tags->pluck('id')->toArray());
        }

        return response()->json(new PostResource($article), Response::HTTP_CREATED);
    }

    public function update(Request $request, Post $article): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
            'excerpt' => 'required|string',
            'status' => 'required|string',
            'commentable' => 'nullable|string',
            'published_at' => [
                'required_if:status,' . PostStatus::Published->value,
                'string'
            ],
            'tags' => 'nullable|array',
            'categories' => 'nullable|array',
        ]);

        $article->title = $request->input('title');
        $article->slug = $request->input('slug');
        $article->body = $request->input('body');
        $article->excerpt = $request->input('excerpt');
        $article->commentable = $request->input('commentable', Commentable::Open);
        $article->status = $request->input('status', PostStatus::Draft);
        $article->published_at = $request->input('published_at');
        $article->save();

        $categories = Category::find($request->input('categories', [1]));

        if ($categories->isNotEmpty()) {
            $article->categories()->sync($categories->pluck('id')->toArray());
        }

        $tags = Tag::find($request->input('tags', []));

        if ($tags->isNotEmpty()) {
            $article->tags()->sync($tags->pluck('id')->toArray());
        }

        return response()->json(new PostResource($article));
    }

    public function destroy(Post $article): \Illuminate\Http\Response
    {
        $article->delete();

        return response()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
