<?php

namespace App\Constant;

use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasLabel
{
    case Publish = 'publish';
    case Draft = 'draft';
    case Future = 'future';
    case Pending = 'pending';
    case Trash = 'trash';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => '草稿',
            self::Publish => '发布',
            self::Future => '定时发布',
            self::Pending => '待审',
            self::Trash => '回收站',
        };
    }
}
