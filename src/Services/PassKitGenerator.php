<?php

namespace RevoSystems\iOSPassKit\Services;

use PKPass\PKPass;
use RevoSystems\iOSPassKit\Notifications\PassKitNotificationToken;

class PassKitGenerator
{
    protected $pass;
    protected $passTypeName;
    protected $passJson;
    protected $passContents;

    public function __construct($pass)
    {
        $this->pass         = $pass;
        $this->passTypeName = $pass::relationName();
        $this->passJson     = $this->mergePass($pass, $this->getBasePass(), $this->getBusinessPass());
    }

    public static function make($pass)
    {
        return new PassKitGenerator($pass);
    }

    public function generate($username)
    {
        $this->buildPKPass($username);
        return tap(config('passKit.passesDirectory') . "/passes/{$username}-" . uniqid() . '.pkpass', function ($pkPassFilePath) {
            return $this->storePass($pkPassFilePath);
        });
    }

    public function update($username)
    {
        $this->buildPKPass($username);
        return tap(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->pass->getSerialNumber()}.pkpass", function ($pkPassFilePath) {
            return $this->storePass($pkPassFilePath);
        });
    }

    public function buildPKPass($username)
    {
        $pass     = new PKPass(PassKitNotificationToken::getApnP12CertificatePath($this->pass), config('passKit.certificatesPassword'));
        $pass->setData($this->passJson);
        $pass->addFile(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->passTypeName}.pass/icon.png");
        $pass->addFile(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->passTypeName}.pass/icon@2x.png");
        $pass->addFile(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->passTypeName}.pass/logo.png");
        $pass->addFile(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->passTypeName}.pass/strip.png");
        $pass->addFile(config('passKit.tenantsDirectory') . "/{$username}/passes/{$this->passTypeName}.pass/strip@2x.png");
        $this->passContents = $pass->create();
    }

    public function getBasePass()
    {
        return json_decode(file_get_contents(config('passKit.passesDirectory') . "/{$this->passTypeName}.json"), true);
    }

    private function getBusinessPass()
    {
        return json_decode(config('passKit.businessClass')::first()->passes, true)[$this->passTypeName];
    }

    public function mergePass($pass, $basePass, $passWithValues)
    {
        $usernameField                                      = config('passKit.username_field');
        $balanceField                                       = $this->pass->getBalanceField();
        $basePass['serialNumber']                           = $pass->getSerialNumber();
//        $basePass['webServiceURL']                          = "https://9be25a1a.ngrok.io/" . config('passKit.routePrefix') . '/' . auth()->user()->$usernameField;
        $basePass['webServiceURL']                          = url(config('passKit.routePrefix')) . '/' . auth()->user()->$usernameField;
        $basePass['authenticationToken']                    = config('passKit.apiToken');
        $basePass['locations']                              = $passWithValues['locations'];
        $basePass['barcode']['message']                     = $passWithValues['barcode']['message'];
        $basePass['organizationName']                       = $passWithValues['organizationName'];
        $basePass['description']                            = $passWithValues['description'];
        $basePass['logoText']                               = $passWithValues['logoText'];
        $basePass['backgroundColor']                        = $passWithValues['backgroundColor'];
        $basePass['foregroundColor']                        = $passWithValues['foregroundColor'];
        $basePass['labelColor']                             = $passWithValues['labelColor'];
        $basePass['storeCard']['primaryFields'][0]['label'] = $passWithValues['storeCard']['primaryFields'][0]['label'];
        $basePass['storeCard']['primaryFields'][0]['value'] = (float)$pass->$balanceField;
        $basePass['storeCard']['backFields']                = $passWithValues['storeCard']['backFields'];
        return $basePass;
    }

    public function storePass($pkPassFilePath)
    {
        $file = fopen($pkPassFilePath, 'w');
        fwrite($file, $this->passContents);
        fclose($file);
    }
}
