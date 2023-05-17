<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\{
    RegisterUserRequest, LoginUserRequest
};
use Illuminate\Http\JsonResponse;
use Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => ['logout']
        ]);
    }

    /**
     * Created a new user
     * 
     * @param RegisterUserRequest $request
     * 
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request) : JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->getToken(auth()->login($user), [
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Check if the credentials are valid and send a access token
     * 
     * @param LoginUserRequest $request
     * 
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request) : JsonResponse
    {
        if (!$token = auth()->attempt($request->all()))
            return response()->json([
                'error' => 'Invalid credentials',
            ], 401);

        return $this->getToken($token);
    }

    /**
     * Invalidates the token
     * 
     * @return JsonResponse
     */
    public function logout() : JsonResponse
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    /**
     * Returns a JSON with access token
     * 
     * @param string $token
     * 
     * @return JsonResponse
     */
    private function getToken(string $token, array $data = [], int $status = 200) : JsonResponse
    {
        $body = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];

        return response()->json($body + $data, $status);
    }
}
