<?php

namespace App\Http\Controllers\Api\V1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Finance\GroupResource;
use App\Models\Finance\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;

class GroupController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        return GroupResource::collection(Group::where('user_id', auth()->id())->get());
    }
}
