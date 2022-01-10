<?php
namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateRightsInfoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => [
                'required'
            ],
            'available_from_date' => [
                'sometimes',
                'required'
            ],
            'expiry_date' => [
                'sometimes',
                'required'
            ],
            'available_rights' => 'sometimes',
            'holdbacks' => 'sometimes',
            'territories' => 'sometimes',
            'title' => [
                'sometimes',
                'required'
            ],
            'short_description' => [
                'sometimes',
                'required'
            ],
            'long_description' => [
                'sometimes',
                'required'
            ]
        ];
    }
}

