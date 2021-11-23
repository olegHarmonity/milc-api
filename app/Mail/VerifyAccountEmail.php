<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccountEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Please verify your email for MILC Platform";

    public $verificationCode = "";

    public function __construct(string $verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }
    
    public function build()
    {
        $webAppUrl = rtrim(config('app.web_url'), '/');
        $verificationUrl = $webAppUrl.'/auth/verify-email/'.$this->verificationCode;

        return $this->markdown('mail.verify')
            ->subject($this->subject)
            ->with(['verificationUrl' => $verificationUrl ]);
    }
}

