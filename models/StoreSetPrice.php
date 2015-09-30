<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "store_set_price".
 */
class StoreSetPrice extends \app\models\base\StoreSetPrice
{
    const STATUS_AVAILABLE = 1;
    const STATUS_EXPIRED = 2;

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = new Expression('NOW()');
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->status_id == self::STATUS_AVAILABLE) {
            self::updateAll(
                [
                    'status_id' => self::STATUS_EXPIRED,
                    'updated_at' => new Expression('NOW()'),
                ],
                'store_set_id=:storeSet && id != :id',
                [
                    ':storeSet' => $this->store_set_id,
                    ':id' => $this->id,
                ]
            );
        }
    }


}
