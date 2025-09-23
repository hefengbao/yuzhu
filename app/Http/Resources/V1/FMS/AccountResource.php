<?php

namespace App\Http\Resources\V1\FMS;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'type' => $this->type,
            'balance' => $this->balance,
            'credit_limit' => $this->credit_limit,
            'settlement_day' => $this->settlement_day,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
