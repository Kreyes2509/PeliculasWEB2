<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class enviarCorreo extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $url;
    protected $codigo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$codigo,$url)
    {
        $this->user = $user;
        $this->codigo=$codigo;
        $this->url=$url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'CONFIRMACION CORREO',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'Email.viewEmail',
            with:[
                "name"=>$this->user->name,
                "codigo"=>$this->codigo,
                "url"=>$this->url
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
