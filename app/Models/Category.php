<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['category_name', 'category_slug'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
