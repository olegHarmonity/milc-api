<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Request;
use App\Mail\VerifyAccountEmail;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'verifyUser',
                'resendVerificationEmail'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // $credentials['is_verified'] = 1;

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'We cant find an account with these credentials. Please make sure you entered the right information and you have verified your email address.'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to login, please try again.'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function verifyUser($verificationCode)
    {
        $check = DB::table('user_verifications')->where('token', $verificationCode)->first();

        if (! is_null($check)) {
            $user = User::find($check->user_id);

            if ($user->is_verified == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account is already verified.'
                ]);
            }

            $user->update([
                'is_verified' => 1
            ]);
            DB::table('user_verifications')->where('token', $verificationCode)->delete();

            return response()->json([
                'success' => true,
                'message' => 'You have successfully verified your email address.'
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => "Verification code is invalid."
        ])->setStatusCode(400);
    }

    public function resendVerificationEmail($email)
    {
        DB::beginTransaction();

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => "Invalid email."
            ])->setStatusCode(400);
        }

        $existingVerification = DB::table('user_verifications')->where('user_id', $user->id)->first();
        
        if(isset($existingVerification->id)){
            DB::table('user_verifications')->delete($existingVerification->id);
        }

        $verificationCode = str_random(30);
        
        DB::table('user_verifications')->insert([
            'user_id' => $user->id,
            'token' => $verificationCode
        ]);

        Mail::to($user->email)->send(new VerifyAccountEmail($verificationCode));

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Verification link has been sent to your email.'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()
                ->getTTL() * 60
        ]);
    }
}
