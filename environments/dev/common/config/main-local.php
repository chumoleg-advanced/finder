<?php
return [
    'components' => [
        'db'     => [
            'dsn'      => 'mysql:host=localhost;dbname=finder',
            'username' => 'root',
            'password' => 'root',
        ],
        'redis'  => [
            'database' => 0,
        ],
    ],
];
