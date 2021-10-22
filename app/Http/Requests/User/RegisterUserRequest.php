<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use LVR\CountryCode\Two;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email'
            ],
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
            'phone_number' => [
                'required',
            ],
            'telephone_number' => [
                'required',
            ],
            'job_title' => [
                'required',
            ],
            'country' => [
                'required',
                //new Two()
            ],
            'city' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'postal_code' => [
                'required',
            ],
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
            'password_confirmation' => [
                'required',
            ]
        ];
    }
}
