<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function unauthenticated($request, array $guards)
    {
        if ($request->route()->getPrefix() && str_contains($request->route()->getPrefix(), 'api')) {
            abort(response()->json([
                'status' => 'error',
                'message' => 'UnAuthenticated'
            ], 401));
        }

        if ($request->route()->getPrefix() == 'backend') {
            return redirect()->route('backend.dashboard');
        }

        return redirect(RouteServiceProvider::HOME);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->route()->getPrefix() && str_contains($request->route()->getPrefix(), 'backend')) {
                return route('backend.login');
            }

            return route('login');
        }
    }
}
