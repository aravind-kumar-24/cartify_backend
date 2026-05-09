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

    public string $user_name;
    public string $url;
    public string $role;

    public function __construct(string $name, string $url, string $role)
    {
        $this->user_name = $name;
        $this->url = $url;
        $this->role = $role;
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
