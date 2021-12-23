<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderRejectedEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public function __construct(string $name, string $orderNumber)
    {
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - order rejected";
        $this->message = "Your order number ".$orderNumber. " has been rejected.";
        $this->message1 = "If you have any questions, please contact our administrators.";
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ]);
    }
}