<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Mime\Message;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $status = 200;
        $credentials = request()->validate(['email' => 'required|email']);
        try {
            $response = Password::sendResetLink($credentials);
            return response()->json(array("status" => 200, "message" => trans($response), "data" => array()), $status);
        } catch (\Swift_TransportException $ex) {
            $status = 400;
            $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        } catch (Exception $ex) {
            $status = 400;
            $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        }

        return response()->json($arr, $status);
    }

    public function reset()
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"]);
    }
}
