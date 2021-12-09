<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => [
                'nullable',
                'string'
            ],
            'is_archived' => [
                'nullable',
                'numeric'
            ],
        ];
    }
}
