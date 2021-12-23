<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BankTransferInitEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "";

    public $message = "";

    public $message1 = "";

    public $name = "";

    public function __construct(string $name, string $orderNumber, string $iban, string $swift_bic, string $bankName)
    {
        $this->name = $name;
        $this->subject = "Order number " . $orderNumber . " status update - bank transfer info";
        $this->message = "You have initiated a bank transfer payment for order number " . $orderNumber;
        $this->message1 = "To proceed with the order, please make a bank transfer payment to the following account: <br><br>IBAN: " . $iban . "<br>SWIFT(BIC): " . $swift_bic . "<br>Bank name: " . $bankName;
    }

    public function build()
    {
        return $this->markdown('mail.default')
            ->subject($this->subject)
            ->with([
            'message' => $this->message,
            'message1' => $this->message1,
            'name' => $this->name
        ]);
    }
}