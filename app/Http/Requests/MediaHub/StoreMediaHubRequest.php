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
            'title' => [
                'required',
                // 'string'
            ],
            'tenant' => [
                // 'required',
            ], 
            'description' => [
                // 'required',
            ],
            'genres' => [
                'nullable'
            ],  
            'externalReference' => [
                'nullable'
            ],
            'poster' => [
                'nullable'
            ],  
            'posterContentType' => [
                'nullable'
            ],
            'posterUrl' => [
                'nullable'
            ],
        ];
    }
}
