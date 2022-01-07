<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class TwoFactorAuthenticationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'nullable',
                'email',
            ],
            'password' => [
                'nullable',
                // 'min:8',
            ],
            'code' => [
                'required',
                'string',
            ],
            
        ];
    }
}
