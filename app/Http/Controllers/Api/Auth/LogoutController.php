<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        if (auth()->check()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'ok',
                'message' => __('message.Logged out successfully')
            ]);
        } else {
            return response()->json(array(
                'status' => 'error',
                'message' => __('Invalid User!')
            ));
        }
    }
}
