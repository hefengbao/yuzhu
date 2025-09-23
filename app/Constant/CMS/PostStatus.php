<?php

namespace App\Constant\CMS;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasLabel, HasColor
{
    case Published = 'published';
    case Draft = 'draft';
    case Rejected = 'rejected';

    /**
     * 临时方案
     * https://github.com/filamentphp/filament/issues/10206
     */
    public static function parse(PostStatus|string|null $value): ?self
    {
        if ($value instanceof self) {
            return $value;
        }

        return self::tryFrom($value);
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => '草稿',
            self::Published => '发布',
            self::Rejected => '驳回',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Published => 'success',
            self::Draft => 'gray',
            self::Rejected => 'danger',
        };
    }
}
