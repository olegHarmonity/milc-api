<?php

namespace App\Http\Requests\MediaHub;

use App\Models\User;
use App\Util\UserStatuses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateMediaHubRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asset_type' => [
                'nullable',
            ],  
            'product_id' => [
                'nullable',
            ],  
            'externalReference' => [
                'nullable',
            ],
        ];
    }
}
