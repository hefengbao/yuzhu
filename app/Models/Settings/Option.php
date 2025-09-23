<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $fillable = [
        'name',
        'value',
        'autoload',
    ];
}
