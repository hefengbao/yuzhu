<?php

namespace App\Repositories;


use App\Models\Comment;
use App\One\Markdown;

class CommentRepository
{
    private $comment;
    private $markdown;

    public function __construct(Comment $comment, Markdown $markdown)
    {
        $this->markdown = $markdown;
        $this->comment = $comment;
    }

    public function save($data)
    {
        $reply = '';
        if (isset($data['comment_parent_name']) && $data['comment_parent_name'] && $data['comment_parent']) {
            $reply = '<a href="#comment-' . $data['comment_parent'] . '">@' . $data['comment_parent_name'] . '</a> ';
        }
        $data['comment_content_filter'] = $this->markdown->convertMarkdownToHtml($reply . $data['comment_content']);
        return $this->comment->create($data);
    }

    public function getAll()
    {
        $data = $this->comment->select('id', 'comment_author', 'comment_content_filter', 'comment_parent', 'created_at')
            ->published()
            ->orderBy('created', 'asc')
            ->get();
        return $data;
    }
}