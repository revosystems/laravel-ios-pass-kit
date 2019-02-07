<?php

namespace RevoSystems\iOSPassKit\Services;

use App\Models\Config\Business;
use PKPass\PKPass;
use RevoSystems\iOSPassKit\Notifications\PassKitNotificationToken;

class PassKitGenerator
{
    public static function generate($username, $pass)
    {
        $tableName  = $pass->getTable();
        $passJson   = static::mergePass($pass, static::getBasePass($tableName), static::getBusinessPass($tableName));
        $pass       = static::buildPKPass($username, $tableName, $passJson);
        $passFile = $pass->create();
        $pkPassFilePath = resource_path("apn/passes") . "/" . uniqid() . ".pkpass";
        $file = fopen($pkPassFilePath, "w");
        fwrite($file, $passFile);
        fclose($file);
        return $pkPassFilePath;
    }

    private static function mergePass($pass, $basePass, $passValues)
    {
        $basePass['serialNumber']                           = $pass->uuid;
        $basePass['locations']                              = $passValues['locations'];
        $basePass['barcode']['message']                     = $passValues['barcode']['message'];
        $basePass['organizationName']                       = $passValues['organizationName'];
        $basePass['description']                            = $passValues['description'];
        $basePass['logoText']                               = $passValues['logoText'];
        $basePass['backgroundColor']                        = $passValues['backgroundColor'];
        $basePass['foregroundColor']                        = $passValues['foregroundColor'];
        $basePass['labelColor']                             = $passValues['labelColor'];
        $basePass['storeCard']['primaryFields'][0]['label'] = $passValues['storeCard']['primaryFields'][0]['label'];
        $basePass['storeCard']['primaryFields'][0]['value'] = (float)$pass->balance;
        $basePass['storeCard']['backFields']                = $passValues['storeCard']['backFields'];
        return $basePass;
    }

    private static function getBasePass($tableName)
    {
        return json_decode(file_get_contents(public_path() . "/{$tableName}_pass.json"), true);
    }

    private static function getBusinessPass($tableName)
    {
        return json_decode(Business::first()->passes, true)[$tableName];
    }

    private static function buildPKPass($username, $tableName, $basePass)
    {
        $password = ''; // TODO: get from config
        $password = '938358295'; // TODO: get from config
        $pass     = new PKPass(PassKitNotificationToken::getApnP12CertificatePath($tableName), $password);
        $pass->setData($basePass);
        $pass->addFile(public_path('tenants') . "/${username}/passes/{$tableName}.pass/icon.png");
        $pass->addFile(public_path('tenants') . "/${username}/passes/{$tableName}.pass/icon@2x.png");
        $pass->addFile(public_path('tenants') . "/${username}/passes/{$tableName}.pass/logo.png");
        $pass->addFile(public_path('tenants') . "/${username}/passes/{$tableName}.pass/strip.png");
        $pass->addFile(public_path('tenants') . "/${username}/passes/{$tableName}.pass/strip@2x.png");
        return $pass;
    }
}
