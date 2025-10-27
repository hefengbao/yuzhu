<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
    protected $table = 'usermetas';
    protected $fillable = ['user_id', 'mete_key', 'meta_value'];
}
