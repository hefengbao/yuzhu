<?php

namespace App\Models\FMS;

use App\Constant\FMS\FinanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\Financial/CategoryFactory> */
    use HasFactory;

    protected $table = 'fms_categories';

    protected $fillable = [
        'name', 'type'
    ];

    protected $casts = [
        'type' => FinanceType::class
    ];

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
