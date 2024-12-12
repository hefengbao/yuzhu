<?php

namespace App\Http\Controllers\Api\V1;

use App\Constant\Post\Commentable;
use App\Constant\Post\PostStatus;
use App\Constant\Post\PostType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(Request $request): JsonResponse
    {
        $pages = Post::with([
            'author',
        ])->page()
            ->when($request->query('key'), function ($query) use ($request) {
                $query->where('id', '<', $request->query('key'));
            })
            ->limit($request->query('page_size', 30))
            ->orderByDesc('id')
            ->get();

        return PostResource::collection($pages)
            ->response()
            ->header('Cache-Control', 'public, max-age=3600')
            ->setEtag(md5($pages->pluck('id')->join(', ')));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
            'commentable' => 'nullable|string',
        ]);

        $page = new Post();
        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->body = $request->input('body');
        $page->excerpt = Str::limit(
            str_replace(PHP_EOL, '', strip_tags(Str::markdown($request->input('body')))),
            120
        );
        $page->commentable = $request->input('commentable', Commentable::Open);
        $page->type = PostType::Page;
        $page->status = PostStatus::Published;
        $page->published_at = Carbon::now();
        $page->author()->associate($request->user());
        $page->save();

        return (new PostResource($page))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Post $page): PostResource
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
            'commentable' => 'nullable|string',
        ]);

        $page->title = $request->input('title');
        $page->slug = $request->input('slug', Str::slug($request->input('title')));
        $page->body = $request->input('body');
        $page->commentable = $request->input('commentable', Commentable::Open);
        $page->excerpt = Str::limit(
            str_replace(PHP_EOL, '', strip_tags(Str::markdown($request->input('body')))),
            120
        );
        $page->save();

        return new PostResource($page);
    }

    public function destroy(Post $page): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
    {
        $page->delete();

        return response()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
