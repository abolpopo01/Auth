<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mess;
    /**
     * Create a new message instance.
     */
    public function __construct($mess)
    {
        $this->mess = $mess;
    }

    public function build()
    {
        return $this->subject("Welcome")->view('welcomeuser')->with(['mess' => $this->mess]);
    }
}
