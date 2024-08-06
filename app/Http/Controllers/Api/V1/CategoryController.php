<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        $tags = Category::all();

        return CategoryResource::collection($tags);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse|CategoryResource
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::where('name', $request->input('name'))->first();

        if ($category) {
            return new CategoryResource($category);
        } else {
            $category = Category::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
            ]);

            return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_CREATED);
        }
    }
}
