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

    public $message = "We are pleased to inform you that your application to register on MILC platform is accepted.
                       Keep informed on the latest updates by following us on <a href=\"https://twitter.com/milcplatform\">Twitter</a> or by joining our <a href=\"www.tg-me.com/MILCplatform\">Telegram</a> group.";

    public $name = '';
    
    public function __construct($name){
        $this->name = $name;
    }
        
    public function build()
    {
        return $this->markdown('mail.default')
            ->subject($this->subject)
            ->with(['message' => $this->message, 'name' => $this->name]);
    }
}
