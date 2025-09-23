<?php

namespace App\Models\FMS;

use App\Casts\UnicodeArray;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\Financial/CategoryFactory> */
    use HasFactory;

    protected $table = 'finance_categories';

    protected $fillable = [
        'user_id', 'group_id', 'name', 'items'
    ];

    protected $casts = [
        'items' => UnicodeArray::class
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
