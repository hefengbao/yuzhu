<?php

namespace App\Models\Settings;

use App\Enums\BlacklistType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'body'];

    protected function casts(): array
    {
        return [
            'type' => BlacklistType::class,
        ];
    }
}
