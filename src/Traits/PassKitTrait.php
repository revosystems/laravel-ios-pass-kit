<?php

namespace RevoSystems\iOSPassKit\Traits;

use RevoSystems\iOSPassKit\Models\PassKitDevice;

trait PassKitTrait
{
    /*
     * Returns a token that will be used to authorize wallet requests
     */
    abstract protected function getPassKitToken();

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
        return $this->morphToMany(PassKitDevice::class, 'pass_kit_registration');
//        return $this->morphToMany(Device::class, 'walletable'); // FIXME: Walletable not correct
    }

    protected function getPassType()
    {
        return array_flip(config('passKit.passTypes')[get_class($this)]);
    }

    public static function findRegistration($serialNumber, $passType)
    {
        return (config('passKit.passTypes')[$passType])::where('uuid', $serialNumber)->firstOrFail();
    }

    public static function registerApn($deviceLibraryIdentifier, $passType, $serialNumber, $apnToken)
    {
        static::findRegistration($serialNumber, $passType)->devices()->attach(PassKitDevice::firstOrCreate([
            'device_library_identifier'        => $deviceLibraryIdentifier,
            config('passKit.apn_token_field')  => $apnToken
        ]));
    }

    public static function unRegisterApn($deviceLibraryIdentifier, $passType, $serialNumber)
    {
        static::findRegistration($serialNumber, $passType)->devices()->detach(
            PassKitDevice::where('device_library_identifier', $deviceLibraryIdentifier)->firstOrFail()
        );
    }
}
