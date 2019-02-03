<?php

use App\Models\Modules\GiftCard;
use Illuminate\Foundation\Auth\User;
use RevoSystems\iOSPassKit\Models\PassKitDevice;

return [
    'routePrefix'           => 'api/passKit',
    'passKitToken'          => 'demo-passKit-token',
    'devices_table'         => 'devices',
    'userClass'             => User::class,
    'deviceClass'           => PassKitDevice::class,
    'username_field'        => 'username',
    'apn_token_field'       => 'token',
    'passesDirectory'       => public_path() . '/',
    'certificatesDirectory' => resource_path('apn'),
    'passTypes' => [
        'pass.works.revointouch.giftcard' => GiftCard::class,
        'pass.works.revointouch.voucher'  => Voucher::class,
    ]
];
