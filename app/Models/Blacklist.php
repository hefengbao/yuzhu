<?php

namespace App\Models;

use App\Constant\BlacklistType;
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
