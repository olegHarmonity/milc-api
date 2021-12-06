<?php
namespace App\Http\Requests\Core;

use App\Util\AllowedCurrencies;
use Illuminate\Foundation\Http\FormRequest;

class ExchangeCurrencyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from_currency' => [
                'string',
                'required',
                'in:' . AllowedCurrencies::getCurrencies(true)
            ],
            'to_currency' => [
                'string',
                'required',
                'in:' . AllowedCurrencies::getCurrencies(true)
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1'
            ],
        ];
    }
}