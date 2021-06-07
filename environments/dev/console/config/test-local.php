<?php
return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;dbname=apple_test',
            'username' => 'root',
            'password' => 'apple_worm',
            'charset' => 'utf8',
        ],
    ],
];