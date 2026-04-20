<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator};

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|min:10|unique:users,mobile',
            'password' => 'required|min:8'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email should be unique',
            'mobile.required' => 'Mobile is required',
            'mobile.numeric' => 'Mobile is invalid',
            'mobile.min' => 'Mobile must be 10 digits long',
            'mobile.unique' => 'Mobile must be unique',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be 8 characters long'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        // create user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = $request->password;
        $user->status = 1;
        $user->save();

        // assign role to user
        $user->assignRole('user');

        // login user using user id
        Auth::loginUsingId($user->id);

        $user = auth()->user();
        $data['user'] = new UserResource($user);
        $data['access_token'] = $user->createToken($user->id)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => __('Registration successful'),
            'data' => $data
        ]);
    }
}
