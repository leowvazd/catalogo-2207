<?php

return[
    'admins'=>[
        'admin@losum.com',
        'admin@lessenzza.com'
    ],

    // Credenciais iniciais do admin em produção (usadas só pelo AdminUserSeeder)
    'initial_admin_email' => env('ADMIN_EMAIL'),
    'initial_admin_password' => env('ADMIN_PASSWORD'),
];