<?php

namespace App\Enums\CMS;

enum PostType: string
{
    case Article = 'article';
    case Page = 'page';
    case Tweet = 'tweet';
}
