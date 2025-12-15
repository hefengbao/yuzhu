<?php

namespace App\Models\FMS;

use App\Enums\FMS\FinanceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\FMS\TransactionFactory> */
    use HasFactory;

    protected $table = 'fms_transactions';

    protected $fillable = [
        'uuid',
        'user_id',
        'account_id',
        'type',
        'date',
        'category_id',
        'tag_id',
        'notes',
        'currency_id',
        'amount'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    protected function casts(): array
    {
        return [
            'type' => FinanceType::class,
            'date' => 'date',
            'amount' => 'decimal:2'
        ];
    }
}
