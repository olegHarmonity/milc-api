<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'rights_bundle_id' => [
                'required'
            ],
        ];
    }
}