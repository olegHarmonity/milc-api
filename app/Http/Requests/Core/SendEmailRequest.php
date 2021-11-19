<?php
namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'emails' => [
                'required'
            ],
            'message' => [
                'required'
            ],
        ];
    }
}

