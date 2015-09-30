<?php
namespace app\assets;

use yii\bootstrap\BootstrapThemeAsset;
use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package app\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/assets';
    public $css = [
        'css/global.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapThemeAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];
}
