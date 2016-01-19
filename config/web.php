<?php

use \yii\base\InvalidConfigException;
use \yii\helpers\ArrayHelper;

$defaultConfig = require(__DIR__.'/default.php');

$config = [
    'bootstrap' => ['log'],
    'modules' => [
        'admin'=>['class' => 'app\modules\admin\Module'],
        'register'=>['class' => 'app\modules\register\Module'],
    ],
    'aliases' => [
        '@admin' => '@app/modules/admin',
        '@register' => '@app/modules/register',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@app/assets',
                    'css' => ['css/bootswatch.min.css']
                ],
            ],
        ],
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

