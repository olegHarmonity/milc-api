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
    
    public $name = "";

    public function __construct(string $verificationCode, string $name)
    {
        $this->verificationCode = $verificationCode;
        $this->name = $name;
    }
    
    public function build()
    {
        $webAppUrl = rtrim(config('app.web_url'), '/');
        $verificationUrl = $webAppUrl.'/auth/verify-email/'.$this->verificationCode;

        return $this->markdown('mail.verify')
            ->subject($this->subject)
            ->with(['verificationUrl' => $verificationUrl, 'name' => $this->name ]);
    }
}

