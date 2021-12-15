<?php
namespace App\Http\Controllers\Order;

use App\Models\Contract;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use Throwable;

class ContractController extends Controller
{
    public function showCheckoutContract(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

            Gate::authorize('view', $order);

            $contract = Contract::where('order_id', '=', $order->id)->first();

            return (new Resource($contract));
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
