<?php

namespace App\Constant;

enum PostType: string
{
    case Article = 'article';
    case Page = 'page';
    case Tweet = 'tweet';
}
