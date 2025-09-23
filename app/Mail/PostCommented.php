<?php

namespace App\Mail;

use App\Models\CMS\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostCommented extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected Comment $comment;

    protected string $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $title, Comment $comment)
    {
        $this->title = $title;
        $this->comment = $comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.post_commented',
            with: ['comment' => $this->comment]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
