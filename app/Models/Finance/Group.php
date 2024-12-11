<?php

namespace App\Models\Finance;

use App\Constant\Finance\FinanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\Finance/GroupFactory> */
    use HasFactory;

    protected $table = 'finance_groups';

    protected $fillable = ['name', 'type', 'user_id'];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    protected function casts(): array
    {
        return [
            'type' => FinanceType::class,
        ];
    }
}
