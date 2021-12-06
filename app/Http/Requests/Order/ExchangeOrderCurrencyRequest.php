<?php
namespace App\Http\Requests\Order;

use App\Util\AllowedCurrencies;
use Illuminate\Foundation\Http\FormRequest;

class ExchangeOrderCurrencyRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'pay_in_currency' => [
                'string',
                'required',
                'in:' . AllowedCurrencies::getCurrencies(true)
            ],
        ];
    }
}