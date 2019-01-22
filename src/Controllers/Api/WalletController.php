<?php

namespace RevoSystems\Wallet\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    public function __middleware()
    {
        \Log::info(request()->toArray());
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
        $device = Device::firstOrCreate([
            "identifier" => request('deviceLibraryIdentifier'),
            "token" => request('data')['token']
        ]);
        Pass::firstOrCreate([
            "passType_id"   => PassType::where('passType', request('passType'))->first()->id,
            "device_id"     => $device->id,
            "serialNumber"  => request('serialNumber'),
        ]);
    }

    public function unRegister()
    {
        Device::findOrFail(request('deviceLibraryIdentifier'))->unRegister(request('passType'), request('serialNumber'));
    }
}
