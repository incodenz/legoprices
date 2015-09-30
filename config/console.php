<?php

use \yii\base\InvalidConfigException;
use \yii\helpers\ArrayHelper;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$defaultConfig = require(__DIR__.'/default.php');

$config =  [
    'id' => 'console',
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
    ],
];


$envConfigPath = __DIR__.'/'.YII_ENV.'/console.php';

if (!file_exists($envConfigPath)) {
    throw new InvalidConfigException('Environment not properly configured.');
}

$envConfig = require($envConfigPath);

return ArrayHelper::merge(
    ArrayHelper::merge($defaultConfig, $config),
    $envConfig
);
