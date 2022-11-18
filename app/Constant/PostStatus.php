<?php

namespace App\Constant;

enum PostStatus: string
{
    case Publish = 'publish';
    case Draft = 'draft';
    case Future = 'future';
    case Pending = 'pending';
    case Trash = 'trash';
}
