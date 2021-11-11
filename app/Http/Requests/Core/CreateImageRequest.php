<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class CreateImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => [
                'required'
            ],
        ];
    }
}
