<?php

return [
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\EmailTarget',
                    'mailer' =>'mailer',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'to' => [WEBMASTER_EMAIL],
                        'from' => [$params['fromEmail']],
                        'subject' => sprintf('[%s] Application Log', $_SERVER['SERVER_NAME'])
                    ],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                    ],
                ],
            ],
        ],
    ],
];
