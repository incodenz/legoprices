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
    const STATUS_OUT_OF_STOCK = 3;

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
        if ($this->status_id != self::STATUS_EXPIRED) {
            self::updateAll(
                [
                    'status_id' => self::STATUS_EXPIRED,
                ],
                'store_set_id=:storeSet && id != :id',
                [
                    ':storeSet' => $this->store_set_id,
                    ':id' => $this->id,
                ]
            );
        }
        if ($insert) {
            $this->notify();
        }
    }

    private function notify()
    {
        if (!$this->storeSet->legoset->rrp) {
            return;
        }
        $rrp = $this->storeSet->legoset->rrp;
        $discount = round(($rrp - $this->price) / $rrp * 100);
        /* @var NotificationSet[] $notifySets */
        $notifySets = NotificationSet::find()->where([
                'set_code' => $this->storeSet->legoset->code,
                'status_id' => NotificationSet::STATUS_PENDING
            ])->andWhere(
                ['<=', 'percent_off', $discount]
            )->all();

        foreach($notifySets as $notifySet) {
            $notifySet->notify($this);
        }
    }


}
