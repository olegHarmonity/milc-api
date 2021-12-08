<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                'string'
            ],
            'content' => [
                'required',
                'string'
            ],
            'user_id' => [
                'nullable'
            ],
        ];
    }
}
