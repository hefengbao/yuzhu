<?php

namespace App\Http\Controllers\Api\V1\FMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FMS\GroupResource;
use App\Models\FMS\Group;
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
