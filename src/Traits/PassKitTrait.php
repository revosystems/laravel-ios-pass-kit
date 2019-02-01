<?php

namespace RevoSystems\iOSPassKit\Traits;

use Illuminate\Notifications\Notifiable;
use RevoSystems\iOSPassKit\Models\PassKitDevice;
use RevoSystems\iOSPassKit\Notifications\PassKitUpdatedNotification;

trait PassKitTrait
{
    use Notifiable;

    /**
     * Finds the walletable instance by its serial number
     */
    abstract public function findBySerialNumber($serialNumber);

    /*
     * Returns pass/giftCard/voucher identifier
     */
    abstract public function getSerialNumber();

    public function devices()
    {
        return $this->morphToMany(PassKitDevice::class, 'pass_kit_registration');
    }

    public static function boot()
    {
        parent::boot();
        static::updating(function ($pass) {
            $usernameField = config('passKit.username_field', 'username');
            $pass->notify(new PassKitUpdatedNotification(auth()->user()->$usernameField, static::class, $pass->getSerialNumber()));
        });
    }

    public static function getPassKitToken()
    {
        return config('passKit.passKitToken', '<replace-by-pass-kit-token>');
    }

    public function routeNotificationForApn()
    {
        return $this->devices()->first()->uuid; // TODO: UPDATE laravel-apn-notification package
        return $this->devices()->pluck('uuid');
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

    public static function getPassTypeRelation($passType)
    {
        return lcfirst(str_plural(class_basename(config('passKit.passTypes')[$passType])));
    }

    public static function getPassTypeTable($passType)
    {
        return snake_case(static::getPassTypeRelation($passType));
    }
}
