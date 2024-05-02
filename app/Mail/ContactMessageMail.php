<?php

namespace App\Mail;

use App\Models\Apartment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $apartmentId;
    public $sender;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($apartmentId, $sender, $subject, $content)
    {
        $this->apartmentId = $apartmentId;
        $this->sender = $sender;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Recupera l'appartamento associato all'ID dell'appartamento
        $apartment = Apartment::findOrFail($this->apartmentId);

        return new Envelope(
            subject: $this->subject,
            from: $apartment->user->email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.contacts.message',
            with: ['content' => $this->content]
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
