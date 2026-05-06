<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuccessfullRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user_name;
    public $url;

    public function __construct($name, $url)
    {
        $this->user_name = $name;
        $this->url = $url;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Successfull',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'EmailTemplates.RegistrationSuccessfullTemplate',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
