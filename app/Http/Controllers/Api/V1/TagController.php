<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse|TagResource
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::where('name', $request->input('name'))->first();

        if ($tag) {
            return new TagResource($tag);
        } else {
            $tag = Tag::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
            ]);

            return (new TagResource($tag))->response()->setStatusCode(Response::HTTP_CREATED);
        }
    }
}
