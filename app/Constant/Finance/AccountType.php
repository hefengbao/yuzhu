<?php

namespace App\Constant\Finance;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccountType: string implements HasLabel, HasColor
{
    case Debit = 'debit';
    case Credit = 'credit';
    case Voucher = 'voucher';
    case Other = 'other';

    public static function parse(AccountType|string|null $value): ?self
    {
        if ($value instanceof self) {
            return $value;
        }

        return self::tryFrom($value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Debit => Color::Indigo,
            self::Credit => Color::Orange,
            self::Voucher => Color::Blue,
            self::Other => Color::Fuchsia,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Debit => '借记卡',
            self::Credit => '信用卡',
            self::Voucher => '代金券',
            self::Other => '其他',
        };
    }
}
