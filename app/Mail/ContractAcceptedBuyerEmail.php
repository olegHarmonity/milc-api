<?php
namespace App\Mail;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class ContractAcceptedBuyerEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject = "";
    
    public $message = "";
    
    public $message1 = "";
    
    public $name = "";
    
    public $pdf = null;
    
    public $pdfName = "";
    
    public function __construct(string $name, string $orderNumber, Contract $contract)
    {
        $this->name = $name;
        $this->subject = "Order number ".$orderNumber." status update - contract accepted";
        $this->message = "You have accepted the contract for order ".$orderNumber;
        $this->message1 = "You can find the contract in the attached PDF document.";
        
        $data['contract_text'] = $contract->contract_text;
        $data['contract_text_part_2'] = $contract->contract_text_part_2;
        $data['contract_appendix'] = $contract->contract_appendix;
        
        $this->pdf = PDF::loadView('pdfs.contract', $data);
        $this->pdfName = "contract_order_no_".$orderNumber;
        
    }
    
    public function build()
    {   
        return $this->markdown('mail.default')
        ->subject($this->subject)
        ->with(['message' => $this->message,'message1' => $this->message1, 'name' => $this->name ])
        ->attachData($this->pdf->output(), $this->pdfName);
    }
}