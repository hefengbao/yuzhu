<?php

namespace App\Constant\Post;

enum PostType: string
{
    case Article = 'article';
    case Page = 'page';
    case Tweet = 'tweet';
}
