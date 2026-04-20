<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleFromHeader
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->is('api/*')) {
            $locale = $request->header('Accept-Language');

            // Determine the supported locales in your application
            $supportedLocales = ['en', 'ar']; // Example locales

            // Check if the requested locale is supported, if not, use the default locale
            if (in_array($locale, $supportedLocales)) {
                app()->setLocale($locale);
            } else {
                app()->setLocale(config('app.locale')); // Set the default locale
            }
        }

        return $next($request);
    }
}
