<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationDeclinedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Your organisation's application for MILC platform has been declined";
    
    public $message = "We are sorry to inform you that your application to register on MILC platform is declined. If you have any further inquiries, please contact our administrators.";
    
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
