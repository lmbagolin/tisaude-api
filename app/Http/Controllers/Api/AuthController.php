<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @OA\Post(
     *     tags={"Autenticação"},
     *     summary="Realiza o login na API",
     *     description="Retorna informaçõs do usuário e o TOKEN de acesso",
     *     path="/api/auth/login",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="E-mail de credencial de acesso",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Senha de credencial de acesso",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Retorna informaçõs do usuário e o TOKEN de acesso"
     *      ),
     * ),
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
                'message' => 'User created successfully. An email has been sent for verification.'
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
     * @OA\Post(
     *     tags={"Autenticação"},
     *     summary="Realiza o logout na API",
     *     description="Invalida o token de acesso do usuário",
     *     path="/api/auth/logout",
     *     @OA\Response(
     *          response="200",
     *          description="Invalida o token de acesso do usuário"
     *      ),
     * ),
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
