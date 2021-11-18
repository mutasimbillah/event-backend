<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\Status;
use App\Models\Image;
use App\Enums\UserType;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where($request->only('phone'))->first();
        if (!$user) {
            return $this->respondWithToken(false); // signal that the phone doesn't exist in db
        }
        if (!Hash::check($request->input('password'), $user->password) || $user->status !== Status::ACTIVE) {
            return $this->unauthorized(); // phone number exists, but the token doesn't match
        }

        return $this->respondWithToken($this->auth()->login($user)); // everything ok, lets login
    }

    /**
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationRequest $request)
    {
        $data = Arr::except($request->validated(), 'image');
        $data['phone_verified_at'] = now();
        //return $data;
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->attachRoles([UserType::CUSTOMER]);

        return $this->respondWithToken($this->auth()->login($user));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->auth()->refresh());
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
        return $this->success([
            'new_user' => !$token,
            'access_token' => $token ?: '',
            'token_type' => 'Bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 60
        ]);
    }
}
