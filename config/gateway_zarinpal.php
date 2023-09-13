<?php

return [

    /**
     *  driver class namespace
     */
    'driver' => Omalizadeh\MultiPayment\Drivers\Zarinpal\Zarinpal::class,

    /**
     *  gateway configurations
     */
    'main' => [
        'authorization_token' => '', // used only to refund payments (can be created from zarinpal panel)
        'merchant_id' => '',
        'callback_url' => 'https://star.starfoods.ir',
        'mode' => 'sandbox', // supported values: normal, zaringate, sandbox
        'description' => 'payment using zarinpal',
    ],
    'other' => [
        'authorization_token' => '',
        'merchant_id' => '',
        'callback_url' => 'https://star.starfoods.ir',
        'mode' => 'normal',
        'description' => 'payment using zarinpal',
    ]
];
