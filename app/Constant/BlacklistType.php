<?php

namespace App\Constant;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BlacklistType: string implements HasLabel, HasColor
{
    case Ip = 'ip';
    case Email = 'email';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ip => 'IP地址',
            self::Email => '邮件地址',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Ip => 'danger',
            self::Email => 'warning',
        };
    }
}
