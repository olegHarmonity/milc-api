<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Util\UserStatuses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

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
                'email', 'unique:users,email,' . $this->user->id
            ],
            'first_name' => [
                'string', 'min:2', 'max:50'
            ],
            'last_name' => [
                'string', 'min:2', 'max:50'
            ],
            'phone_number' => [
                'string'
            ],
            'password' => [
                'string', 'confirmed', 'min:8'
            ],
            'job_title' => [
                'string'
            ],
            'country' => [
                'string', 'min:2', 'max:2'
            ],
            'city' => [
                'string'
            ],
            'address' => [
                'string'
            ],
            'postal_code' => [
                'string'
            ],
            'status' => [
                'string', 'in:' . UserStatuses::getUserStatuses(true)
            ],
            'image_id' => []
        ];
    }
}
