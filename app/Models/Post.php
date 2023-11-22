<?php

namespace App\Models;

use App\Constant\Commentable;
use App\Constant\PostStatus;
use App\Constant\PostType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Vinkla\Hashids\Facades\Hashids;

class Post extends Model implements Feedable
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
        'user_id',
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
        'published_at' => 'datetime',
        'status' => PostStatus::class,
        'type' => PostType::class,
        'commentable' => Commentable::class,
        'tags' => 'array',
        'categories' => 'array',
    ];

    public static function getFeedItems()
    {
        return Post::with(['author'])->published()->orderBy('published_at', 'desc')->get();
    }

    public function slugId(): Attribute
    {
        return Attribute::make(
            get: fn() => slug_id($this->slug, $this->id)
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function tags2(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function categories2(): BelongsToMany
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

    public function isPage(): bool
    {
        return $this->type === PostType::Page;
    }

    public function isArticle(): bool
    {
        return $this->type === PostType::Article;
    }

    public function isPinned(): bool
    {
        return $this->pinned_at !== null;
    }

    public function isPublished(): bool
    {
        return $this->status === PostStatus::Publish;
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

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => Hashids::connection('alternative')->encode($this->id),
            'title' => $this->title ?? Str::limit($this->body, 50),
            'summary' => $this->excerpt ?? Str::limit($this->body),
            'updated' => $this->updated_at,
            'link' => match ($this->type) {
                PostType::Tweet->value => \route('tweets.show', $this->slug_id),
                PostType::Article->value => \route('articles.show', $this->slug_id),
                PostType::Page->value => \route('pages.show', $this->slug_id),
            },
            'authorName' => $this->author ? $this->author->name : url('/'),
        ]);
    }
}
