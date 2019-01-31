<?php

return [
    'routePrefix'           => 'api/external/passKit',
    'passKitToken'          => '<passKit-token>',
    'devices_table'         => 'apn_tokens',
    'userClass'             => User::class,
    'deviceClass'           => PassKitDevice::class,
    'username_field'        => 'username',
    'apn_token_field'       => 'token',
    'serial_number_field'   => 'serial_number',
    'passesDirectory'       => public_path() . '/tenants/',
    'passTypes' => [
        //'pass.works.revointouch.giftcard' => GiftCard::class,
        //'pass.works.revo.voucher'     => Voucher::class,
    ]
];
