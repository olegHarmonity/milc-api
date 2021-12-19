<?php
namespace App\Http\Requests\Order;


use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationContractRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'contract_text' => [
                'sometimes',
                'required'
            ],
            'contract_appendix' => [
                'sometimes',
                'required'
            ],
        ];
    }
}