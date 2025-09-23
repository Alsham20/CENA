<?php

namespace App\Mail;

use App\Models\ContactMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $follow;
    public $accuse;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMail $contact, $follow = true,$accuse=false)
    {
        //
        $this->contact = $contact;
        $this->follow = $follow;
        $this->accuse = $accuse;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: (!$this->accuse) ? 'Formulaire de contact' : 'A.R.S Accusé de réception',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: (!$this->accuse) ? 'mail.contact-mail' : 'mail.accuse-contact',
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
