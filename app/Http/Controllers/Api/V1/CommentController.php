<?php

namespace App\Http\Controllers\Api\V1;

use App\Constant\CommentStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CommentResourece;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index($id): ResourceCollection
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments()->with(['author'])->approved()->get();

        return CommentResourece::collection($comments);
    }

    public function store($id,Request $request)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'body' => 'required'
        ]);

        $comment = $post->comments()->create([
            'parent_id' => $request->input('parent_id'),
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'status' => CommentStatus::Approved,
        ]);

        return (new CommentResourece($comment))->response()->setStatusCode(201);
    }
}
