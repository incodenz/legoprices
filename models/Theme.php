<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theme".
 */
class Theme extends \app\models\base\Theme
{
    public function __toString()
    {
        return (string) $this->description;
    }
}
