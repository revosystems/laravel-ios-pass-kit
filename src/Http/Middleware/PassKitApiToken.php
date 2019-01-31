<?php

namespace RevoSystems\iOSPassKit\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitApiToken
{
    public function handle($request, Closure $next, $api = 'app')
    {
        if (! $this->validateRequest()) {
            return response()->json()->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    private function verifyToken($authToken)
    {
        return $authToken == 'ApplePass ' . PassKitTrait::getPassKitToken();
    }

    private function verifyPassExists($serialNumber, $passType)
    {
        return PassKitTrait::findRegistration($serialNumber, $passType);
    }

    private function validateRequest()
    {
        return $this->verifyToken(request()->header('Authorization')) && $this->verifyPassExists(request()->route('serialNumber'), request()->route('passType'));
    }
}
