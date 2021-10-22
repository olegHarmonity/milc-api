<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function me()
    {
        return response()->json(auth()->user());
    }
}
