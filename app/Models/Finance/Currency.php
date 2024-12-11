<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\Finance/CurrencyFactory> */
    use HasFactory;

    protected $table = 'finance_currencies';

    protected $fillable = ['name', 'code', 'symbol'];
}
