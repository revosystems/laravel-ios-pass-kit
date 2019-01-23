<?php

namespace RevoSystems\iOSWallet\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use RevoSystems\iOSWallet\Models\Pass;

class WalletController extends Controller
{
    public function __middleware()
    {
        if (! $this->verifyAuthToken(request('data')['token'])) {
            return response()->json(['status' => Response::HTTP_UNAUTHORIZED, 'message' => 'Wrong token']);
        }
        return request()->next();
    }

    private function verifyAuthToken($token)
    {
        $token = explode("-", $token, 2);
        createDBConnection($token[0], true);
        if (! auth()->user()) {
            return false;
        }
        return GiftCard::exists("uuid", $token[1]);
    }

    public function register()
    {
        Pass::registerApn(request('deviceLibraryIdentifier'), request('serialNumber'));
    }

    public function unRegister()
    {
        Pass::unRegisterApn(request('deviceLibraryIdentifier'), request('serialNumber')); /*, only have one passType request('passType')*/
    }
}
