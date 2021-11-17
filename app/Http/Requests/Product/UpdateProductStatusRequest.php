<?php
namespace App\Http\Requests\Product;

use App\Util\ProductStatuses;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'status' => [
                'required',
                'string', 
                'in:' . ProductStatuses::getProductStatuses(true)
            ]
        ];
    }
}