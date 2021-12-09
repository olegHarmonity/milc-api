<?php
namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class GeneralAdminSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'iban' => [
                'sometimes',
                'string',
                'required',
            ],
            'bank_name' => [
                'sometimes',
                'required'
            ],
            'swift_bic' => [
                'sometimes',
                'string',
                'required',
            ],
        ];
    }
}
