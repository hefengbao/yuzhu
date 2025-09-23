<?php

namespace App\Constant\CMS;

enum PostType: string
{
    case Article = 'article';
    case Page = 'page';
    case Tweet = 'tweet';
}
