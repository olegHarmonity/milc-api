<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Order;

class OrderCompleteEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public $pdf = null;
    
    public $pdfName = "";
    
    public function __construct(string $name, string $orderNumber, Order $order)
    {
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - order complete";
        $this->message = "Your order number ".$orderNumber." has been marked as completed.";
        $this->message1 = "If you have any questions, please contact our administrators.";
        
        $data['order'] = $order;
        $this->pdf = PDF::loadView('pdfs.order', $data);
        $this->pdfName = "order_no_".$orderNumber;
    }
    
    public function build()
    {
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ])
        ->attachData($this->pdf->output(), $this->pdfName);
    }
}