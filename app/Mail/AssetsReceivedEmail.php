<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssetsReceivedEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $name = "";
        
    public function __construct(string $name, string $orderNumber)
    {
        
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - assets received";
        $this->message = "Assets for order number ".$orderNumber." have been marked as received.";
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message, 'name' => $this->name ]);
    }
}
