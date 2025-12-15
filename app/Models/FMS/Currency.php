<?php

namespace App\Models\FMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\Finance\CurrencyFactory> */
    use HasFactory;

    protected $table = 'fms_currencies';

    protected $fillable = ['name', 'code', 'symbol'];
}
