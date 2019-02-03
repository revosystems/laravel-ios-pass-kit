<?php

namespace RevoSystems\iOSPassKit\Notifications;

use Illuminate\Support\Facades\Config;
use NotificationChannels\Apn\ApnServiceProvider;
use RevoSystems\iOSPassKit\Traits\PassKitTrait;

class PassKitNotificationToken
{
    public static function setup($passType)
    {
        Config::set('broadcasting.connections.apn', [
            'environment' => 1,
            'certificate' => self::getApnCertificatePath($passType),
            'pass_phrase' => null, // Optional passPhrase
        ]);
        (new ApnServiceProvider(app()))->boot();
    }

    public static function getApnCertificatePath($passType)
    {
        return config('passKit.certificatesDirectory') . '/' . lcfirst(str_plural(class_basename($passType))) . '-apns-passes-cert.pem';
    }
}
