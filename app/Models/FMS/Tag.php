<?php

namespace App\Models\FMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    protected $table = 'fms_tags';

    protected $fillable = ['category_id', 'name'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
