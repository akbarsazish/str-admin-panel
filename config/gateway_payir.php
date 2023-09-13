<?php

return [

    /**
     *  driver class namespace
     */
    'driver' => Omalizadeh\MultiPayment\Drivers\PayIr\PayIr::class,

    /**
     *  gateway configurations
     */
    'main' => [
        'api_key' => '', // use 'test' as api_key for sandbox mode
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using payir',
    ],
    'other' => [
        'api_key' => '',
        'callback_url' => 'https://star.starfoods.ir',
        'description' => 'payment using payir',
    ]
];
