<?php

namespace App\Http\Resources\V1;

use App\Constant\PostType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => match ($this->type) {
                PostType::Article => route('articles.show', $this->slug_id),
                PostType::Page => route('pages.show', $this->slug_id),
                PostType::Tweet => route('tweets.show', $this->slug_id)
            },
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'body_html' => Str::markdown($this->body),
            'type' => $this->type,
            'status' => $this->status,
            'commentable' => $this->commentable,
            'comment_count' => $this->comment_count,
            'pinned_at' => $this->pinned_at,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->author),
            'categories' => CategoryResource::collection($this->categories ?? []),
            'tags' => TagResource::collection($this->tags ?? []),
            'can_edit' => $this->author->id == auth()->id(),
            'can_delete' => $this->author->id == auth()->id(),
        ];
    }
}
