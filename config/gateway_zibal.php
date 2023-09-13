<?php

return [

    /**
     *  driver class namespace
     */
    'driver' => Omalizadeh\MultiPayment\Drivers\Zibal\Zibal::class,

    /**
     *  gateway configurations
     */
    'main' => [
        'merchant'  => '', // use 'zibal' for sandbox (testing) mode
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using zarinpal',
    ],
    'other' => [
        'merchant'  => '',
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using zarinpal',
    ]
];
