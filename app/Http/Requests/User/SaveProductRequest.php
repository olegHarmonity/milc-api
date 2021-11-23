<?php
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'product_id' => 'required'
        ];
    }
}

