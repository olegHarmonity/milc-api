<?php

namespace App\Http\Requests\Organisation;

use App\Models\Organisation;
use App\Models\User;
use App\Util\CompanyRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateOrganisationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
        //$organisation = Organisation::find($this->route('organisation'));
        //return Gate::authorize('update', $organisation);
    }

    public function rules()
    {
        return [
            'organisation_name' => [
            ],
            'organisation_type_id',
            'registration_number' => [
            ],
            'phone_number',
            'telephone_number',
            'organisation_role' => [
                'in:' . CompanyRoles::getRolesForValidation()
            ],
            'description' => [
            ],
            'website_link' => [
            ],
            'country' => [
                'min:2',
                'max:2'
            ],
            'city',
            'address',
            'postal_code',
            'social_links',
            'website_link',
            'logo_id'
        ];
    }
}
