<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancelledEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public function __construct(string $name, string $orderNumber)
    {
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - order cancelled";
        $this->message = "You have cancelled the order number ".$orderNumber;
        $this->message1 = "If you have any questions, please contact our administrators.";
        
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ]);
    }
}