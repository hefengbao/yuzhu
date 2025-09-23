<?php

namespace App\Constant\CMS;

use Filament\Support\Contracts\HasLabel;

enum Commentable: string implements HasLabel
{
    case Open = 'open';
    case Closed = 'closed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => '开启',
            self::Closed => '关闭',
        };
    }
}
