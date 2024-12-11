<?php

namespace App\Models\Finance;

use App\Constant\Finance\AccountType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\Finance/AccountFactory> */
    use HasFactory;

    protected $table = 'finance_accounts';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance',
        'credit_limit',
        'settlement_day',
        'status',
        'notes'
    ];

    protected function casts(): array
    {
        return [
            'type' => AccountType::class,
            'balance' => 'decimal:2',
            'credit_limit' => 'decimal:2',
            'settlement_day' => 'integer',
            'status' => 'boolean'
        ];
    }
}
