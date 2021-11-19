<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationAcceptedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Your organisation's application for MILC platform has been accepted";

    public $message = "We are pleased to inform you that your application to register on MILC platform is accepted.";

    public function build()
    {
        return $this->markdown('mail.default')
            ->subject($this->subject)
            ->with([
            'message',
            $this->message
        ]);
    }
}
