<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        try {
            $credentials = $request->only('email', 'password');
            if(!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $token = auth()->user()->createToken('API Token')->plainTextToken;
            if ($token === false) {
                throw new \Throwable('Error in login');
            }
            $user = Auth::user();
            $res = ['user' => $user];
            return response($res, 200)
            ->header('access_token', $token)
            ->header('token_type', 'Bearer');
        }
        catch(Exception $err) {
            $res = [
                'status_code' => 401,
                'message' => 'Error in login',
                'error' => $err
            ];
            return response()->json($res);
        }
    }

    public function register(RegisterRequest $request)
    {
        $request['password'] = Hash::make($request->password);
        $createUser = User::create($request->all());
        return $createUser;
    }
    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        $request->user()->currentAccessToken()->delete();

        return response()->json(["status" => "Logout success"]);
    }
}
