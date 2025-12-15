<?php

namespace App\Models\FMS;

use App\Enums\FMS\FinanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\FMS\CategoryFactory> */
    use HasFactory;

    protected $table = 'fms_categories';

    protected $fillable = [
        'user_id', 'parent_id', 'name', 'type'
    ];

    protected $casts = [
        'type' => FinanceType::class
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
