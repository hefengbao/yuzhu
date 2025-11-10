<?php

namespace App\Enums\FMS;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FinanceType: string implements HasLabel, HasColor
{
    case Expense = 'expense'; // 支出
    case Income = 'income'; // 收入
    case Transfer = 'transfer'; // 转账
    case Reconciliation = 'reconciliation'; // 平账

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Expense => Color::Red,
            self::Income => Color::Green,
            self::Transfer => Color::Blue,
            self::Reconciliation => Color::Amber,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Expense => __('fms.expense'),
            self::Income => __('fms.income'),
            self::Transfer => __('fms.transfer'),
            self::Reconciliation => __('fms.reconciliation'),
        };
    }
}
