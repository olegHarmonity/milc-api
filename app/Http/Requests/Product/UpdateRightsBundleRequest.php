<?php
namespace App\Http\Requests\Product;

use App\Util\AllowedCurrencies;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRightsBundleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
      
            'price' => [
                'sometimes',
                'required'
            ],
            'price.value' => [
                'sometimes',
                'required'
            ],
            'price.currency' => [
                'sometimes',
                'required',
                'in:' . AllowedCurrencies::getCurrencies(true)
            ],
            'rights_information' => [
                'sometimes',
                'array',
                'min:1'
            ],
        ];
    }
}
