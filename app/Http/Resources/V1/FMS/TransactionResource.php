<?php

namespace App\Http\Resources\V1\FMS;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'account' => new AccountResource($this->account),
            'type' => $this->type,
            'date' => $this->date->format('Y-m-d'),
            'category' => new CategoryResource($this->category),
            'notes' => $this->notes,
            'currency' => new CurrencyResource($this->currency),
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
