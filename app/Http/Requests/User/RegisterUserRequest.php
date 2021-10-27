<?php

namespace App\Http\Requests\User;

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
                'min:2',
                'max:50'
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:50'
            ],
            'phone_number',
            'job_title' => [
                'required',
            ],
            'country' => [
                'required',
                'min:2',
                'max:2'
            ],
            'city',
            'address',
            'postal_code',
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
            'password_confirmation' => [
                'required',
            ],
            'organisation.organisation_name' => [
                'required',
            ],
            'organisation.organisation_type_id',
            'organisation.registration_number' => [
                'required',
            ],
            'organisation.phone_number',
            'organisation.telephone_number',
            'organisation.organisation_role' => [
                'required',
                'in:' . CompanyRoles::getRolesForValidation()
            ],
            'organisation.description' => [
                'required',
            ],
            'organisation.website_link' => [
                'required',
            ],
            'social_links',
            'website_link',
            'logo_id'
        ];
    }
}
