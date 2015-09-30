<?php

define('YII_ENV', require(__DIR__.'/../environment.php'));
// yii2 does not provide a staging env constant by default.
defined('YII_ENV_STAGE') or define('YII_ENV_STAGE', YII_ENV === 'stage');
defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV === 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();