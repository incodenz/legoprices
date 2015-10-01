<?php

use \yii\base\InvalidConfigException;
use \yii\helpers\ArrayHelper;

$defaultConfig = require(__DIR__.'/default.php');

$config = [
    'bootstrap' => ['log'],
    'modules' => [
        'admin'=>['class' => 'app\modules\admin\Module']
    ],
    'aliases' => [
        '@admin' => '@app/modules/admin',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sjqU1WzKQcnsDGZmoVXk9remxm0scIqH',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'user/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'user/login',
                'about' => 'site/about',
                'logout' => 'user/logout',
                'set/<code:([0-9]+)>' => 'set/view',
            ]
        ],
    ],
];


$envConfigPath = __DIR__.'/'.YII_ENV.'/web.php';

if (!file_exists($envConfigPath)) {
    throw new InvalidConfigException('Environment not properly configured.');
}

$envConfig = require($envConfigPath);

return ArrayHelper::merge(
    ArrayHelper::merge($defaultConfig, $config),
    $envConfig
);

