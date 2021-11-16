<?php

namespace App\Http\Requests\User;

use App\Util\UserRoles;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->isCompanyAdmin(true);
    }

    public function rules()
    {
        return [
            'email' => [
                'required', 'email', 'unique:users'
            ],
            'first_name' => [
                'required', 'string', 'min:2', 'max:50'
            ],
            'last_name' => [
                'required', 'string', 'min:2', 'max:50'
            ],
            'phone_number' => [
                'string'
            ],
            'password' => [
                'required', 'string', 'confirmed', 'min:8'
            ],
            'avatar' => [
                'image', 'max:2000'
            ],
            'organisation_id' => [
                'sometimes', 'integer', 'exists:organisations,id'
            ]
        ];
    }
}
