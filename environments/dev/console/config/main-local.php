<?php
return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;dbname=apple_dev',
            'username' => 'apple_user',
            'password' => 'apple_red',
            'charset' => 'utf8',
        ],
    ],

    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
