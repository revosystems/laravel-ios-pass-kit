<?php

namespace RevoSystems\iOSPassKit\Notifications;

use Illuminate\Support\Facades\Config;
use NotificationChannels\Apn\ApnServiceProvider;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitNotificationToken
{
    public static function setup($passClass)
    {
        Config::set('broadcasting.connections.apn', [
            'environment' => 1,
            'certificate' => static::getApnCertificatePath($passClass),
            'pass_phrase' => null, // Optional passPhrase
        ]);
        (new ApnServiceProvider(app()))->boot();
    }

    public static function getApnCertificatePath($passClass)
    {
        return config('passKit.certificatesDirectory') . "/{$passClass::relationName()}-apns-passes-cert.pem";
    }

    public static function getApnP12CertificatePath($passClass)
    {
        return config('passKit.certificatesDirectory') . "/{$passClass::relationName()}-crypt-passes-cert.p12";
    }
}
