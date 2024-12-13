<?php

namespace App\Http\Controllers\Api\V1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Finance\CategoryResource;
use App\Models\Finance\Category;
use Illuminate\Http\JsonResponse;
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
        return CategoryResource::collection(Category::where('user_id', auth()->id())->get());
    }
}
