<?php

namespace App\Constant\FMS;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FinanceType: string implements HasLabel, HasColor
{
    case Expense = 'expense';
    case Income = 'income';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Expense => Color::Red,
            self::Income => Color::Green,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Expense => __('finance.expense'),
            self::Income => __('finance.income'),
        };
    }
}
