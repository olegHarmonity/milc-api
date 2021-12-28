<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use App\Util\NotificationCategories;

class StoreNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'required'
            ],
            'message' => [
                'required'
            ],
            'category' => [
                'required',
                'in:' . NotificationCategories::getCategories(true)
            ],
            'organisation_id' => [
                'sometimes'
            ],
            'sender_id' => [
                'sometimes'
            ],
            'is_for_admin' => [
                'sometimes'
            ],
        ];
    }
}
