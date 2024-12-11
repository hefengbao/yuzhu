<?php

namespace App\Http\Controllers\Api\V1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Finance\AccountResource;
use App\Models\Finance\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;

class AccountController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(): ResourceCollection
    {
        $accounts = Account::where('user_id', auth()->id())
            ->where('status', 1)
            ->get();

        return AccountResource::collection($accounts);
    }

    public function store(Request $request): AccountResource
    {

    }
}
