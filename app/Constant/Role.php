<?php

namespace App\Models;

enum Role: string
{
    case Administrator = 'administrator';
    case Author = 'author';
}
