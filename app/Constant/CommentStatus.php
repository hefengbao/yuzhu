<?php

namespace App\Constant;

use Filament\Support\Contracts\HasLabel;

enum CommentStatus: string implements HasLabel
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
}
