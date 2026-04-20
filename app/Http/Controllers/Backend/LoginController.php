<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Backend\LoginRequest;
use Exception;

class LoginController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function checking_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('backend.dashboard')->with('success', 'You have entered an invalid credentials');
            } else {
                return redirect()->back()->with('danger', 'You have entered an invalid credentials');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('backend.login')->with('success', 'Logout successfull');
    }
}
