<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be 8 characters long'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        ];

        // validate user credentials
        if (!auth()->attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Credentials']);
        }

        $user = auth()->user();
        // validate user role
        if (!$user->hasRole('user')) {
            auth()->logout();
            return response()->json(['status' => 'error', 'message' => 'You are not authorized to login.']);
        }

        $data['user'] = new UserResource($user);
        $data['access_token'] = $user->createToken($user->id)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => __('Logged in successfully'),
            'data' => $data
        ]);
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['status' => 'success', 'message' => 'Logout successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid user']);
        }
    }
}
