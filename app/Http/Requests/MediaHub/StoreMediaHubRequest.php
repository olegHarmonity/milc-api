<?php

namespace App\Http\Requests\MediaHub;

use App\Util\UserRoles;
use Illuminate\Foundation\Http\FormRequest;

class StoreMediaHubRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filename' => [
                'required',
                // 'string'
            ],
            'type' => [
                'required',
                'string'
            ],
            'tenantName' => [
                'nullable'
            ],  
            'externalReference' => [
                'nullable'
            ],
            'assetId' => [
                'nullable'
            ],  
            'metadata' => [
                'nullable'
            ],
        ];
    }
}
