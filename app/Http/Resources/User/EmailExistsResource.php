<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailExistsResource extends JsonResource
{
    public function toArray($request)
    {
        $emailExists = parent::toArray($request);

        if ($emailExists['email_exists'] === true) {
            $emailExists['message'] = "User with entered email already exists!";
            return $emailExists;
        }

        $emailExists['message'] = "No user found with entered email.";
        return $emailExists;
    }
}
