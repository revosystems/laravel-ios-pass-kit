<?php

namespace RevoSystems\iOSWallet\Traits;

use RevoSystems\iOSWallet\Models\Device;

trait WalletTrait
{
    /*
     * Returns a token that will be used to authorize wallet requests
     */
    abstract protected function getWalletToken();

    /**
     * Finds the walletable instance by its serial number
     */
    abstract public function findBySerialNumber($serialNumber);

    /*
     * Returns pass/giftCard/voucher identifier
     */
    abstract protected function getSerialNumber();

    /*
     * Returns pass type bundle generated on iTunes connect. Starts with pass.whatever.bundle.you.have
     */

    public function devices()
    {
        return $this->morphToMany(Device::class, 'walletable'); // FIXME: Walletable not correct
    }

    protected function getPassType()
    {
        return array_flip(config('wallet.passTypes')[get_class($this)]);
    }

    public static function findWalletable($serialNumber, $passType)
    {
        return (config('wallet.passTypes')[$passType])::where('uuid', $serialNumber)->firstOrFail();
    }

    public static function registerApn($deviceLibraryIdentifier, $passType, $serialNumber, $apnToken)
    {
        static::findWalletable($serialNumber, $passType)->devices()->attach(
            Device::firstOrCreate([
                'device_library_identifier'                 => $deviceLibraryIdentifier,
                config('wallet.apn_token_field')   => $apnToken
            ])
        );
    }

    public static function unRegisterApn($deviceLibraryIdentifier, $passType, $serialNumber)
    {
        static::findWalletable($serialNumber, $passType)->devices()->detach(
            Device::where('device_library_identifier', $deviceLibraryIdentifier)->firstOrFail()
        );
    }
}
