<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractAcceptedBuyerEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public function __construct(string $name, string $orderNumber)
    {
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - contract accepted";
        $this->message = "You have accepted the contract for order ".$orderNumber;
        //todo: attach contract PDf
        $this->message1 = "You can find the contract in the attached PDF document.";
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ]);
    }
}