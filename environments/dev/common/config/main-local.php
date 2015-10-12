<?php
return [
    'components' => [
        'db'     => [
            'dsn'      => 'mysql:host=localhost;dbname=searcher',
            'username' => 'root',
            'password' => 'root',
        ],
        'redis'  => [
            'database' => 0,
        ],
    ],
];
