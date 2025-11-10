<?php

namespace App\Enums\FMS;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccountType: string implements HasLabel, HasColor
{
    case Debit = 'debit'; // 借记卡
    case Credit = 'credit'; // 信用卡
    case DigitalAccount = 'digital_account'; // 数字账户
    case GiftCard = 'gift_card'; // 礼品卡
    case AccountRecharge = 'account recharge'; // 充值（预付）
    case VirtualAccount = 'virtual_account'; // 虚拟账户
    case Other = 'other'; // 其他

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
            self::Debit => Color::Blue,
            self::Credit => Color::Red,
            self::DigitalAccount => Color::Fuchsia,
            self::GiftCard => Color::Green,
            self::AccountRecharge => Color::Indigo,
            self::VirtualAccount => Color::Amber,
            self::Other => Color::Cyan,

        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Debit => '借记卡',
            self::Credit => '信用卡',
            self::DigitalAccount => '数字账户',
            self::GiftCard => '礼品卡',
            self::AccountRecharge => '账户充值（预付）',
            self::VirtualAccount => '虚拟账户',
            self::Other => '其他类型',
        };
    }
}
