<?php

use Illuminate\Foundation\Auth\User;
use RevoSystems\Demo\Models\Business;
use RevoSystems\Demo\Models\GiftCard;
use RevoSystems\Demo\Models\Voucher;
use RevoSystems\iOSPassKit\Models\PassKitDevice;

return [
    'routePrefix'           => 'api/passKit',
    'apiToken'              => env('PASSKIT_API_TOKEN', 'demo-passKit-token'),
    'devices_table'         => 'devices',
    'userClass'             => User::class,
    'deviceClass'           => PassKitDevice::class,
    'businessClass'         => Business::class,
    'businessTable'         => 'businesses',
    'username_field'        => 'name',
    'apn_token_field'       => 'token',
    'tenantsDirectory'      => 'public/tenants',
//    'tenantsDirectory'      => public_path('tenants'),
    'passesDirectory'       => 'resources/passKit',
//    'passesDirectory'       => resource_path('passKit'),
    'certificatesDirectory' => 'resources/apn',
//    'certificatesDirectory' => resource_path('apn'),
    'certificatesPassword'  => env('PASSKIT_CERTIFICATES_PASSWORD', 'rvstms'),
    'passTypes' => [
        'pass.works.revointouch.giftcard' => GiftCard::class,
        'pass.works.revointouch.voucher'  => Voucher::class,
    ]
];
