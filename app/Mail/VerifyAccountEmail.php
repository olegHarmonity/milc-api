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

        $message = "Thank you for creating an account with MILC Platform. Don't forget to complete your registration!";
        $message1 = "Please click on the link below or copy it into the address bar of your browser to confirm your email address: <a href=\"$verificationUrl\">Confirm my email address</a>";
        return $this->markdown('mail.default')
            ->subject($this->subject)
            ->with(['message' => $message, 'message1' => $message1, 'name' => $this->name ]);
    }
}

