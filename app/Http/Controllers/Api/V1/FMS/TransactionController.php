<?php

namespace App\Http\Controllers\Api\V1\FMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\FMS\TransactionRequest;
use App\Http\Resources\V1\FMS\TransactionResource;
use App\Models\FMS\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;

class TransactionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return ['auth:sanctum'];
    }

    public function index(Request $request): ResourceCollection
    {
        $data = Transaction::with([
            'tag' => function ($query) {
                $query->with('category');
            },
            'account',
            'currency'
        ])
            ->where('user_id', auth()->id())
            ->whereBetween(
                'date',
                [$request->query('start', now()->firstOfMonth()->format('Y-m-d')), $request->query('end', now()->format('Y-m-d'))]
            )
            ->get();

        return TransactionResource::collection($data);
    }

    public function store(TransactionRequest $request): TransactionResource
    {
        /** @var User $user */
        $user = auth()->user();

        $uuid = Str::uuid();

        $transaction = Transaction::create([
            'uuid' => $uuid,
            'user_id' => $user->id,
            'account_id' => $request->input('account_id'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            'tag_id' => $request->input('tag_id'),
            'amount' => $request->input('amount'),
            'currency_id' => $user->financeSettings->currency_id ?? 1,
            'note' => $request->input('note'),
        ]);

        return new TransactionResource($transaction);
    }

    public function update(TransactionRequest $request, Transaction $transaction): TransactionResource
    {
        /** @var User $user */
        $user = auth()->user();

        if ($transaction->user_id != $user->id) {
            abort(403);
        }

        $transaction = $transaction->update([
            'account_id' => $request->input('account_id'),
            'type' => $request->input('type'),
            'date' => $request->input('date'),
            'tag_id' => $request->input('tag_id'),
            'amount' => $request->input('amount'),
            'currency_id' => $user->fmsSettings->currency_id ?? 1,
            'note' => $request->input('note'),
        ]);

        return new TransactionResource($transaction);
    }
}
