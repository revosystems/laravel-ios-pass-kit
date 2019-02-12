<?php

use RevoSystems\Demo\Models\Business;
use RevoSystems\Demo\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    $userNameAndPassword = 'revo';
    return [
        'name'              => $userNameAndPassword,
        'email'             => $faker->email,
        'password'          => bcrypt($userNameAndPassword),
        'remember_token'    => str_random(10),
    ];
});

$factory->define(Business::class, function (Faker\Generator $faker) {
    return [
        "passes" => json_encode([
                "giftCards" => [
                    "serialNumber" => "1234",
                    "locations" => [
                        [
                            "latitude" => 41.673385,
                            "longitude" => 1.764578,
                            "relevantText" => "Benet home is near you."
                        ]
                    ],
                    "barcode" => [
                        "message" => "1234",
                        "format" => "PKBarcodeFormatQR",
                        "messageEncoding" => "iso-8859-1"
                    ],
                    "organizationName" => "REVO",
                    "description" => "Gift Card",
                    "logoText" => "Gift Card",
                    "backgroundColor" => "#3B312F",
                    "foregroundColor" => "#F2653A",
                    "labelColor" => "#F2653A",
                    "storeCard" => [
                        "primaryFields" => [
                            [
                                "label" => "Saldo"
                            ]
                        ],
                        "backFields" => [
                            [
                                "key" => "giftcard-code",
                                "label" => "Gift Card",
                                "value" => "1234"
                            ],[
                                "key" => "website",
                                "label" => "Check our website",
                                "value" => "http =>//www.example.com/track-bags/XYZ123"
                            ]
                        ]
                    ]
                ]
            ]
        )
    ];
});
