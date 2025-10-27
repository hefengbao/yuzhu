<?php

namespace App\Models\FMS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    /** @use HasFactory<\Database\Factories\Finance/SettingsFactory> */
    use HasFactory;

    protected $table = 'fms_settings';

    protected $fillable = ['user_id', 'currency_id'];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
