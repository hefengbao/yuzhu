<?php

namespace App\Models;

use App\Constant\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    const selectField = [
        'id',
        'slug',
        'user_id',
        'title',
        'status',
        'commentable',
        'comment_count',
        'pinned_at',
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'status',
        'type',
        'commentable',
        'comment_count',
        'pinned_at',
        'published_at'
    ];

    protected $casts = [
        'pinned_at' => 'datetime',
        'published_at' => 'datetime'
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function meta(): HasMany
    {
        return $this->hasMany(Postmeta::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::Publish);
    }

    public function scopeArticle($query)
    {
        return $query->where('type', 'article');
    }

    public function scopePage($query)
    {
        return $query->where('type', 'page');
    }

    public function scopeTweet($query)
    {
        return $query->where('type', 'tweet');
    }

    /*public function setPostSlugAttribute($value)
    {
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        str_shuffle($str);
        $suffix=substr(str_shuffle($str),26,10);
        $this->attributes['post_slug'] = $value.'-'.$suffix;
    }*/
}
