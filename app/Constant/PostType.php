<?php

namespace App\Constant;

enum Role: string
{
    case Administrator = 'administrator';
    case Editor = 'editor';
    case Author = 'author';
}
