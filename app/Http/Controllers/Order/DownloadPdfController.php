<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;
use Barryvdh\DomPDF\Facade as PDF;

class DownloadPdfController extends Controller
{

    public function downloadOrderPDF(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

        Gate::authorize('view', $order);

        $data['order'] = $order;

        $pdf = PDF::loadView('pdfs.order', $data)->setPaper('a4', 'portrait');
        $pdfName = "order_no_".$orderNumber.'.pdf';

        if($request->has('download')){
            return $pdf->download($pdfName);
        }

        view()->share('order',$order);
        return view('pdfs.order');
    }

    public function downloadContractPDF(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

        Gate::authorize('view', $order);

        $contract = $order->contract;

        $data['contract_text'] = $contract->contract_text;
        $data['contract_text_part_2'] = $contract->contract_text_part_2;
        $data['contract_appendix'] = $contract->contract_appendix;

        $pdf = PDF::loadView('pdfs.contract', $data)->setPaper('a4', 'portrait');
        $pdfName = "contract_order_no_".$orderNumber.'.pdf';

        if($request->has('download')){
            return $pdf->download($pdfName);
        }

        view()->share($data);
        return view('pdfs.contract');
    }
}
