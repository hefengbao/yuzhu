<?php

namespace App\Http\Controllers\Api\V1\FMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FMS\CategoryResource;
use App\Http\Resources\V1\FMS\TagResource;
use App\Models\FMS\Category;
use App\Models\FMS\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;

class TagController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        return TagResource::collection(Tag::all());
    }

    public function store(Request $request): TagResource
    {
        return new TagResource(Tag::create($request->all()));
    }
}
