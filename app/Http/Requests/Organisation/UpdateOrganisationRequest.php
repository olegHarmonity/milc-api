<?php

namespace App\Http\Requests\Organisation;

use App\Util\CompanyRoles;
use Illuminate\Foundation\Http\FormRequest;
use App\Util\VatRuleNames;

class UpdateOrganisationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'organisation_name' => [
                'sometimes',
                'required',
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:organisations'
            ],
            'organisation_type_id' => [
                'sometimes',
                'required',
            ],
            'registration_number' => [
                'sometimes',
                'required',
            ],
            'phone_number' => [
                'sometimes',
            ],
            'telephone_number' => 'sometimes',
            'organisation_role' => [
                'sometimes',
                'in:' . CompanyRoles::getRolesForValidation()
            ],
            'description' => 'sometimes',
            'website_link' => 'sometimes',
            'country' => [
                'sometimes',
                'min:2',
                'max:2'
            ],
            'city' => 'sometimes',
            'address' => 'sometimes',
            'postal_code' => 'sometimes',
            'social_links' => 'sometimes',
            'website_link' => 'sometimes',
            'logo_id' => 'sometimes',
            'logo' => 'sometimes',
            'iban' => [
                'sometimes',
                'string',
                'required',
            ],
            'bank_name' => [
                'sometimes',
                'required'
            ],
            'swift_bic' => [
                'sometimes',
                'string',
                'required',
            ],
            'vat_rules' => [
                'sometimes',
            ],
            'vat_rules.*.rule_type' => [
                'required',
                'in:' . VatRuleNames::getRules(true)
            ],
            'vat_rules.*.country' => [
                'sometimes',
                'string',
                'min:2',
                'max:2',
            ],
            'vat_rules.*.vat' => [
                'sometimes',
            ],
            'vat_rules.*.vat.value' => [
                'required',
            ],
        ];
    }
}
