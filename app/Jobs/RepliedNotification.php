<?php

namespace App\Jobs;

use App\Constant\PostType;
use App\Mail\PostCommented;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RepliedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Comment $comment;

    protected string $title;

    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->title = '';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $post = $this->comment->post;
        $postAuthor = $post->author;
        /** @var Comment $parent */
        $parent = $this->comment->parent;

        $this->title .= match ($post->type) {
            PostType::Page => '页面《' . $post->title . '》',
            PostType::Article => '文章《' . $post->title . '》',
            PostType::Tweet => '微博《' . \Str::limit($post->body, 30) . '》'
        };

        if ($this->comment->user_id) { // 登录用户评论
            if ($postAuthor->id != $this->comment->user_id) {
                \Mail::to($postAuthor)->send(new PostCommented('您的' . $this->title . '有新的评论', $this->comment));
            }

            if ($parent) {
                if ($parent->user_id) {
                    if ($parent->user_id != $this->comment->user_id) {
                        \Mail::to($parent->author)->send(new PostCommented('您在' . $this->title . '下的评论有新的回复', $this->comment));
                    }
                } else {
                    \Mail::to($parent->guest_email)->send(new PostCommented('您在' . $this->title . '下的评论有新的回复', $this->comment));
                }
            }
        } else {// 游客评论
            if ($postAuthor->email != $this->comment->guest_mail) {
                // 通知 post author
                \Mail::to($postAuthor)->send(new PostCommented('您的' . $this->title . '有新的评论', $this->comment));
            }

            if ($parent) {
                if ($parent->user_id) {
                    if ($parent->author->email != $this->comment->guest_email) {
                        \Mail::to($parent->author)->send(new PostCommented('您在' . $this->title . '下的评论有新的回复', $this->comment));
                    }
                } else {
                    if ($parent->guest_email != $this->comment->guest_email) {
                        \Mail::to($parent->guest_email)->send(new PostCommented('您在' . $this->title . '下的评论有新的回复', $this->comment));
                    }
                }
            }
        }
    }
}
