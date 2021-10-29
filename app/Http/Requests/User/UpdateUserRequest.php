<?php

namespace App\Http\Requests\User;

use App\Util\CompanyRoles;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'email',
                'unique:users'
            ],
            'first_name' => [
                'min:2',
                'max:50'
            ],
            'last_name' => [
                'min:2',
                'max:50'
            ],
            'phone_number',
            'job_title' => [
            ],
            'country' => [
                'min:2',
                'max:2'
            ],
            'city',
            'address',
            'postal_code',
        ];
    }
}
