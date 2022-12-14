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
            'asset_type' => [
                'required',
            ],  
            'product_id' => [
                'required',
            ],  
            'external_reference' => [
                'required',
            ],
        ];
    }
}
