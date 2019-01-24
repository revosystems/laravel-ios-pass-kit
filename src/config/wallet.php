<?php

return [
    'routePrefix'           => 'api/external/wallet',
    'devices_table'         => 'apn_tokens',
    'apn_token_field'       => 'token',
    'serial_number_field'   => 'serial_number',
    'passTypes' => [
        'pass.works.revointouch.giftcard' => GiftCard::class,
        //'pass.works.revo.voucher'     => Voucher::class,
    ]
];
