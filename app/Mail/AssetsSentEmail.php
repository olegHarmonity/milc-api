<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssetsSentEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public function __construct(string $name, string $orderNumber)
    {
        
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - assets sent";
        $this->message = "Assets for order number ".$orderNumber." have been marked as sent.";
        //todo: add correct link for assets download
        $this->message1 = "You can download them at <a href=\"\">link</a>";
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ]);
    }
}