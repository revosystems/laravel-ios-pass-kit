<?php

namespace RevoSystems\iOSWallet\Traits;

use RevoSystems\iOSWallet\Models\Device;

trait WalletTrait
{
    /*
     * Returns a token that will be used to authorize wallet requests
     */
    abstract protected function getWalletToken();
    
    /*
     * Returns pass/giftCard/voucher identifier
     */
    abstract protected function getSerialNumber();
    
    /*
     * Returns pass type bundle generated on iTunes connect. Starts with pass.whatever.bundle.you.have
     */
    abstract protected function getPassType();

    public static function registerApn($deviceLibraryIdentifier, $serialNumber)
    {
        Device::firstOrCreate([
            'device_library_identifier'                 => $deviceLibraryIdentifier,
            config('wallet.apn_token_field', 'token')   => request('data')['token']
        ])->register($serialNumber);
    }

    public static function unRegisterApn($deviceLibraryIdentifier, $serialNumber)
    {
        Device::where('device_library_identifier', $deviceLibraryIdentifier)->firstOrFail()->unRegister($serialNumber);
    }
}
