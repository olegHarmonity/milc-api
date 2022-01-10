<?php
namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Http\Requests\Core\ExchangeCurrencyRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use App\Helper\CurrencyExchange;

class MoneyController extends Controller
{

    public function exchangeCurrency(ExchangeCurrencyRequest $request)
    {
        try {
            $exchangeRequest = $request->validated();
            $response = CurrencyExchange::changeCurrency($exchangeRequest['from_currency'], $exchangeRequest['to_currency'], $exchangeRequest['amount']);
           
            return response()->json([
                "status" => Response::HTTP_OK,
                "data" => $response,
                "message" => "Successfully fetched currency exchange!"
            ]);
        } catch (Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
