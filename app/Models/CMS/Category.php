<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'cms_categories';
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'cms_category_post')->whereNotNull('published_at');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
