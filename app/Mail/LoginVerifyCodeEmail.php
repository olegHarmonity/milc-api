<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginVerifyCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $code;
    public $subject = "Your two factor code.";
    public string $name;
    public string $message = "Your two factor code is:";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.default')
                    ->subject($this->subject)
                    ->with(['message' => $this->message, 'message1' => $this->code, 'name' => $this->name]);
    }
}
