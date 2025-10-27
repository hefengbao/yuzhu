<?php

namespace App\Models\CMS;

use App\Constant\CMS\CommentStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'cms_comments';
    protected $fillable = ['user_id', 'body', 'guest_name', 'guest_email', 'ip', 'user_agent', 'status'];

    protected $with = ['author'];

    protected $casts = [
        'status' => CommentStatus::class,
    ];

    public function userName(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->author ? $this->author->name : $this->guest_name,
        );
    }

    public function userEmail(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->author ? $this->author->email : $this->guest_email,
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
