<?php

namespace App\Constant;

enum CommentStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Spam = 'spam';
    case Trash = 'trash';
}
