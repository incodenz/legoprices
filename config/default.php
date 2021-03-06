<?php

define('WEBMASTER_EMAIL', 'lego@incode.co.nz'); // define the default email address

$params = require(__DIR__ . '/params.php');

date_default_timezone_set('UTC'); // Keep this set to UTC

$config = [
    'id' => 'lego-prices',
    'name' => 'Brick Prices',
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
            'nullDisplay' => '<span class="not-set">(unknown)</span>'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'scriptUrl' => '/index.php',
            'baseUrl' => '',
            'hostInfo' => 'http://lego.incode.nz',
            'rules' => [
                'login' => 'user/login',
                'about' => 'site/about',
                '' => 'site/index',
                'top' => 'site/top',
                'logout' => 'user/logout',
                'set/<code:([0-9]+)>' => 'set/view',
                'register' => 'register/default/index',
                'register/start' => 'register/default/start',
                'register/continue' => 'register/default/continue',
                'register/detail' => 'register/default/detail',
                'register/confirm' => 'register/default/confirm',
                'register/home' => 'register/default/home',
                'register/pay' => 'register/default/pay',
                'register/events' => 'register/default/events',
                'register/prizes' => 'register/default/prizes',
                'register/fees' => 'register/default/fees',

            ]
        ],
        'db' => [
            'on afterOpen' => function($event) {
                $event->sender->createCommand("SET time_zone = '+00:00';")->execute();
            }
        ],
    ],
    'params' => $params,
];

return $config;

