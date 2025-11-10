<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BlacklistType: string implements HasLabel, HasColor
{
    case Ip = 'ip';
    case Email = 'email';
    case ContentMd5 = 'content_md5';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ip => 'IP地址',
            self::Email => '邮件地址',
            self::ContentMd5 => '内容MD5',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Ip => 'danger',
            self::Email => 'warning',
            self::ContentMd5 => 'gray',
        };
    }
}
