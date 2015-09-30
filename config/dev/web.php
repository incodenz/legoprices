<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ]
    ]
];
