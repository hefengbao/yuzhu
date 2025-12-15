<?php

namespace App\Http\Controllers\Api\V1\FMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FMS\CategoryResource;
use App\Models\FMS\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(Request $request): CategoryResource
    {
        return new CategoryResource(Category::create($request->all()));
    }
}
