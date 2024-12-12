<?php

namespace App\Constant\Post;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CommentStatus: string implements HasLabel, HasColor
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Spam = 'spam';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Approved => '已批准',
            self::Pending => '待审',
            self::Spam => '垃圾评论',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Approved => 'success',
            self::Pending => 'warning',
            self::Spam => 'danger',
        };
    }
}
