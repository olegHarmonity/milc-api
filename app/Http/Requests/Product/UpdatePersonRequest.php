<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => [
                'required',
                'min:2',
                'max:50'
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:50'
            ],
            'image_id => []'
        ];
    }
}
