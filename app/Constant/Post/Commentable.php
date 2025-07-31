<?php

namespace App\Constant\Post;

use Filament\Support\Contracts\HasLabel;

enum Commentable: string implements HasLabel
{
    case Open = 'open';
    case Close = 'close';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => '开启',
            self::Close => '关闭',
        };
    }
}
