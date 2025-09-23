<?php

namespace App\Http\Controllers\Api\V1\CMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CMS\TagResource;
use App\Models\CMS\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller implements HasMiddleware
{
    private string $cacheKey = 'tags';

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        $tags = Cache::rememberForever($this->cacheKey, function () {
            return Tag::all();
        });

        return TagResource::collection($tags);
    }

    public function store(Request $request): JsonResponse|TagResource
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::where('name', $request->input('name'))->first();

        Cache::forget($this->cacheKey);

        if ($tag) {
            return new TagResource($tag);
        } else {
            $tag = Tag::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
            ]);

            return (new TagResource($tag))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED)
                ->header('Cache-Control', 'public, max-age=3600')
                ->setEtag(md5($tag->updated_at));
        }
    }
}
