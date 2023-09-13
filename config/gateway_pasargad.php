<?php

return [

    /**
     *  driver class namespace
     */
    'driver' => Omalizadeh\MultiPayment\Drivers\Pasargad\Pasargad::class,

    /**
     *  gateway configurations
     */
    'main' => [
        'merchant_code'  => '5015060',
        'terminal_code' => '2263969',
        'certificate_type' => 'xml_file', // supported values: xml_file, xml_string
        'certificate' => 'C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml', // certificate as a string or certificate.xml file path
        'callback_url' => 'https://starfoods.ir/sucessPay'
    ],
    'other' => [
        'merchant_code'  => '',
        'terminal_code' => '',
        'certificate_type' => 'xml_file',
        'certificate' => '',
        'callback_url' => 'https://star.starfoods.ir',
    ]
];
