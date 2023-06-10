<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWTCheck', ['except' => ['login', 'register']]);
    }

    public function register(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $user = new User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = bcrypt($req->password);
            $user->address = $req->address;
            $user->save();

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function login(Request $req)
    {

        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);
            $token = null;
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 402);
            }
            $credentials = $req->only('email', 'password');
            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], 401);
            }
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        return response()->json(Auth::guard()->user());
    }
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'User successfully signed out']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to logout', 'error' => $e], 500);
        }
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
