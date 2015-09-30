<?php

define('WEBMASTER_EMAIL', 'lego@incode.co.nz'); // define the default email address

$params = require(__DIR__ . '/params.php');

date_default_timezone_set('UTC'); // Keep this set to UTC

$config = [
    'id' => 'lego-prices',
    'name' => 'Lego Prices',
    'basePath' => dirname(__DIR__),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'timeFormat' => 'short',
            'defaultTimeZone' => date_default_timezone_get(),
            'timeZone' => 'Pacific/Auckland', // Change this timeZone to your local if required
            'datetimeFormat' => 'dd/MM/yyyy HH:mm aa',
        ],
    ],
    'params' => $params,
];

return $config;

