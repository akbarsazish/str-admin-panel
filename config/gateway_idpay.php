<?php

return [

    /**
     *  driver class namespace
     */
    'driver' => Omalizadeh\MultiPayment\Drivers\IDPay\IDPay::class,

    /**
     *  gateway configurations
     */
    'main' => [
        'api_key' => '',
        'sandbox' => true, // turning on/off sandbox (testing) mode
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using idpay',
    ],
    'other' => [
        'api_key' => '',
        'sandbox' => true,
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using idpay',
    ]
];
