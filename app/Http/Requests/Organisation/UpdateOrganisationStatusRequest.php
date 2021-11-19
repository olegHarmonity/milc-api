<?php
namespace App\Http\Requests\Organisation;

use App\Util\OrganisationStatuses;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'status' => [
                'required',
                'string',
                'in:' . OrganisationStatuses::getStatuses(true)
            ]
        ];
    }
}