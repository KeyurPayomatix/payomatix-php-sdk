<?php

return [
    'base_url' => 'https://admin.payomatix.com',

    'endpoints' => [
        'hosted_transaction' => '/payment/merchant/v2/transaction',
        'seamless_transaction' => '/payment/merchant/v2/seamless/transaction',
        'transaction_status' => '/payment/merchant/v2/get/transaction',
    ],
];
