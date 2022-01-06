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
use App\Mail\LoginVerifyCodeEmail;
use App\Models\UserActivity;
use App\Util\UserActivities;
use App\Util\UserStatuses;
use App\Util\OrganisationStatuses;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'loginVerify',
                'verifyUser',
                'resendVerificationEmail'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'invalid_credentials'
            ], 401);
        }

        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to login, please try again.'
            ], 401);
        }

        if (!$user->is_verified) {
            return response()->json([
                'success' => false,
                'error' => 'not_verified'
            ], 401);
        }

        if ($user->status !== UserStatuses::$ACTIVE) {
            return response()->json([
                'success' => false,
                'error' => 'user_inactive'
            ], 401);
        }

        if ($user->organisation) {
            if ($user->organisation->status === OrganisationStatuses::$PENDING) {
                return response()->json([
                    'success' => false,
                    'error' => 'organisation_pending'
                ], 401);
            }

            if ($user->organisation->status === OrganisationStatuses::$DECLINED) {
                return response()->json([
                    'success' => false,
                    'error' => 'organisation_declined'
                ], 401);
            }
        }

        // DB::beginTransaction();
        DB::table('user_activities')->insert(['user_id' => auth()->user()->id, 'activity' => UserActivities::$LOGIN, 'created_at' => new \DateTime()]);
        // DB::commit();

        Mail::to($user->email)->send(new LoginVerifyCodeEmail($user->generateTwoFactorCode(), $user->first_name));

        return $this->returnResponse([], 200, __('auth.login_code.sent'));

        // return $this->respondWithToken($token);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function loginVerify(Request $request)
    {

        $token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'two_factor_code' => $request->code,
        ]);

        if (!$token) {
            return $this->returnResponse([], 401, __('auth.invalid_code'));
        }

        $user = auth()->user();
        $user->resetTwoFactorCode();

        return $this->respondWithToken($token);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
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

        if (!is_null($check)) {
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

        if (isset($existingVerification->id)) {
            DB::table('user_verifications')->delete($existingVerification->id);
        }

        $verificationCode = str_random(30);

        DB::table('user_verifications')->insert([
            'user_id' => $user->id,
            'token' => $verificationCode
        ]);

        Mail::to($user->email)->send(new VerifyAccountEmail($verificationCode, $user->first_name));

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
