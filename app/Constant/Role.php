<?php

namespace App\Constant;

use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    case Administrator = 'administrator';
    case Editor = 'editor';
    case Author = 'author';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Administrator => '管理员',
            self::Editor => '编辑',
            self::Author => '作者',
        };
    }
}
