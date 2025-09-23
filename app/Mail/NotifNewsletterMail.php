<?php

namespace App\Mail;

use App\Models\NewsLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifNewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;
    public $follow;

    /**
     * Create a new message instance.
     */
    public function __construct(NewsLetter $newsletter, $follow=true)
    {
        //
        $this->newsletter = $newsletter;
        $this->follow = $follow;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ((!$this->newsletter->is_active) ? "DESABONNEMENT":"ABONNEMENT").' AU NEWSLETTER DE L\'A.R.S',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.notification-abonnement',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
