<?php

return [
    'liqpay' => [
        'public_key' => env('LIQPAY_PUBLIC_KEY', ''),
        'private_key' => env('LIQPAY_PRIVATE_KEY', ''),
        'api_url' => env('LIQPAY_API_URL', 'https://www.liqpay.ua/api/'),
        'checkout_url' => env('LIQPAY_CHECKOUT_URL', 'https://www.liqpay.ua/api/3/checkout'),
        'return_url' => env('LIQPAY_RETURN_URL', ''),
        'test_mode' => env('LIQPAY_TEST_MODE', true),
    ]
];