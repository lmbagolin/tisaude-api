<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * @var $auth Tymon\JWTAuth\JWTGuard
     */
    protected $auth;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = auth('api');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = $this->auth->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            DB::beginTransaction();

            $input = $request->all();
            $user = User::create($input);
            //$user->sendEmailVerificationNotification();
            $reponse = [
                'success' => true,
                'message' => 'Usuario criado com sucesso. Um email foi encaminhado para verificação.'
            ];

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            $reponse = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($reponse);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->auth->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->auth->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        /**
         * @var $user App\Models\User
         */
        $user = $this->auth->user();

        if (!$user->email_verified_at) {
            return response()->json(['error' => 'Unauthorized - Email não verificado'], 401);
        } else {
            $response_user = new UserResource($user);

            return response()->json([
                'user' => $response_user,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->auth->factory()->getTTL() * 60
            ]);
        }
    }
}
