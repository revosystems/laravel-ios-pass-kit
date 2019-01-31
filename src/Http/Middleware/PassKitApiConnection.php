<?php

namespace RevoSystems\iOSPassKit\Http\Middleware;

use Closure;

class PassKitApiConnection
{
    public function handle($request, Closure $next, $api = 'app')
    {
        createDBConnection(request()->route('account'), true);
        auth()->login(config('passKit.userClass')::where(config('passKit.username_field', 'username'), request()->route('account'))->first());
        return $next($request);
    }
}
