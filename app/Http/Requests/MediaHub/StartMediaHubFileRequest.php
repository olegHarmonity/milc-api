<?php

namespace App\Http\Requests\MediaHub;

use App\Util\UserRoles;
use Illuminate\Foundation\Http\FormRequest;

class StartMediaHubFileRequest extends FormRequest
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
            ],  
            'type' => [
                'required',
            ],  
            'externalReference' => [
                'required',
            ],
            'assetId' => [
                'required',
            ],
        ];
    }
}
