<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Middleware;

class PhoneNumberVerified extends Middleware
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
            if (! $request->user() || $request->user()->active === 0) {
                return $request->expectsJson()
                    ? abort(403, 'Your Phone number is not verified.')
                    : Redirect::guest(URL::route($redirectToRoute ?: 'getverify'));
            }
        return $next($request);
    }
}
