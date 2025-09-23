<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    protected $fillable = ['meta_key', 'meta_value'];
}
