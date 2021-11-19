<?php
namespace App\Http\Controllers;

use App\Http\Requests\Core\SendEmailRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\Email;

class EmailController extends Controller
{

    public function sendEmail(SendEmailRequest $request)
    {
        Gate::authorize('send', Email::class);

       $request->validated();

        return response()->json(["status" => Response::HTTP_CREATED, "message" => "Email has been successfully sent!"]);
    }
}
