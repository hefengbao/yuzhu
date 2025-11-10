<?php

namespace App\Http\Controllers\Api\V1\CMS;

use App\Enums\CMS\Commentable;
use App\Enums\CMS\PostStatus;
use App\Enums\CMS\PostType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CMS\PostResource;
use App\Models\CMS\Post;
use App\Models\CMS\Tag;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TweetController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(Request $request): JsonResponse
    {
        $tweets = Post::with([
            'author',
            'tags',
        ])->tweet()
            ->when($request->query('key'), function ($query) use ($request) {
                $query->where('id', '<', $request->query('key'));
            })
            ->limit($request->query('page_size', 10))
            ->orderByDesc('id')
            ->get();

        return PostResource::collection($tweets)
            ->response()
            ->header('Cache-Control', 'public, max-age=3600')
            ->setEtag(md5($tweets->pluck('id')->join(', ')));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'body' => 'required|string',
            'tags' => 'nullable|array',
            'commentable' => 'nullable|string',
        ]);

        $tweet = new Post();
        $tweet->body = $request->input('body');
        $tweet->excerpt = Str::limit(str_replace(PHP_EOL, '', strip_tags(Str::markdown($request->input('body')))), 120);
        $tweet->slug = Str::slug(Str::random());
        $tweet->commentable = $request->input('commentable', Commentable::Open);
        $tweet->type = PostType::Tweet;
        $tweet->status = PostStatus::Published;
        $tweet->published_at = Carbon::now();
        $tweet->author()->associate($request->user());
        $tweet->save();

        $tags = Tag::find($request->input('tags', []));

        if ($tags->isNotEmpty()) {
            $tweet->tags()->attach($tags->pluck('id')->toArray());
        }

        return (new PostResource($tweet))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Request $request, Post $tweet): PostResource
    {
        $request->validate([
            'body' => 'required|string',
            'tags' => 'nullable|array',
            'commentable' => 'nullable|string',
        ]);

        $tweet->body = $request->input('body');
        $tweet->excerpt = Str::limit(str_replace(PHP_EOL, '', strip_tags(Str::markdown($request->input('body')))), 120);
        $tweet->commentable = $request->input('commentable', Commentable::Open);
        $tweet->save();

        $tags = Tag::find($request->input('tags', []));

        if ($tags->isNotEmpty()) {
            $tweet->tags()->sync($tags->pluck('id')->toArray());
        }

        return new PostResource($tweet);
    }

    public function destroy(Post $tweet): \Illuminate\Http\Response
    {
        $tweet->delete();

        return response()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
