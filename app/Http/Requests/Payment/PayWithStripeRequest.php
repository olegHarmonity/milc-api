<?php
namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PayWithStripeRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'number' => [
                'required',
                'numeric',
            ],
            'cvc' => [
                'required',
                'numeric',
            ],
            'exp_month' => [
                'required',
                'numeric',
            ],
            'exp_year' => [
                'required',
                'numeric',
            ],
        ];
    }
}