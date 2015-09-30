<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store".
 */
class Store extends \app\models\base\Store
{
    public static function findStore($title) {
        return self::find()->where(['hash' => $title])->one();
    }
}
