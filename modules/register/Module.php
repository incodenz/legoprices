<?php

namespace app\modules\register;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\User;

/**
 * Class Module
 * @package app\modules\admin
 */
class Module extends \yii\base\Module
{


    /**
     * @param $context
     * @return array
     */
    public function getMenuItems($context)
    {
        return [

        ];
    }
}