<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "MILC platform - action required";

    public $message = "";

    public function __construct(string $message, string $subject = null)
    {
        $this->message = $message;
        if ($subject) {
            $this->subject = $subject;
        }
    }

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
