<?php
namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\SendEmailRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;

class EmailController extends Controller
{

    public function sendEmail(SendEmailRequest $request)
    {
        Gate::authorize('send', Email::class);

        $emailRequest = $request->validated();
        
        $subject = null;
        if(isset($emailRequest['subject'])){
            $subject = $emailRequest['subject'];
        }

        foreach ($emailRequest['emails'] as $toEmail) {
            Mail::to($toEmail)->send(new CustomEmail($emailRequest['message'], $subject));
        }

        return response()->json([
            "status" => Response::HTTP_OK,
            "message" => "Email has been successfully sent!"
        ]);
    }
}
