<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Util\CompanyRoles;
use Illuminate\Foundation\Http\FormRequest;

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
                'email',
                'unique:users'
            ],
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:50'
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:50'
            ],
            'phone_number' => [
                'required',
                'string'
            ],
            'job_title' => [
                'required',
                'string'
            ],
            'country' => [
                'required',
                'string',
                'min:2',
                'max:2'
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
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
            'organisation.organisation_name' => [
                'required',
                'string'
            ],
            'organisation.email' => [
                'required',
                'email'
            ],
            'organisation.organisation_type_id' => [
                'integer',
                'exists:organisation_types,id'
            ],
            'organisation.registration_number' => [
                'string'
            ],
            'organisation.phone_number' => [
                'string'
            ],
            'organisation.telephone_number' => [
                'string'
            ],
            'organisation.organisation_role' => [
                'required',
                'in:' . CompanyRoles::getRolesForValidation()
            ],
            'organisation.description' => [
                'required',
                'string'
            ],
            'organisation.website_link' => [
                'required',
                'string'
            ],
            'organisation.country' => [
                'required',
                'string',
                'min:2',
                'max:2'
            ],
            'organisation.city' => [
                'string'
            ],
            'organisation.address' => [
                'string'
            ],
            'organisation.postal_code' => [
                'string'
            ],
            'organisation.social_links' => [
                'array'
            ],
            'organisation.website_link' => [
                'string'
            ],
        ];
    }
}
