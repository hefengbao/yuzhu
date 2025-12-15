<?php

namespace App\Models\FMS;

use App\Enums\FMS\FinanceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    protected $table = 'fms_tags';

    protected $fillable = ['user_id', 'category_id', 'name', 'type'];

    protected $casts = [
        'type' => FinanceType::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
