<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminContractRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'contract_text_part_2' => [
                'sometimes',
                'required'
            ],
        ];
    }
}