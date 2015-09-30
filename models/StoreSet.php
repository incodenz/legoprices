<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "store_set".
 *
 * @property StoreSetPrice $currentPrice
 * @property string $price
 */
class StoreSet extends \app\models\base\StoreSet
{
    private $_price;

    /**
     * @param Store $store
     * @param LegoSet $set
     * @return null|StoreSet
     */
    public static function findSet($store, $set) {
        return self::find()->where(['store_id' => $store->id, 'legoset_id' => $set->id])->one();
    }

    public function updatePrice($price) {
        $currentPrice = $this->getCurrentPrice();
        if (!$currentPrice || $currentPrice->price != $price) {
            $currentPrice = $currentPrice ? $currentPrice : new StoreSetPrice();
            $currentPrice->updated_at = new Expression('NOW()');
            $currentPrice->price = $price;
            $currentPrice->store_set_id = $this->id;
            $currentPrice->status_id = StoreSetPrice::STATUS_AVAILABLE;
            if (!$currentPrice->save()) {
                // do something
            }
        } else {
            // same price - update
            $currentPrice->updated_at = new Expression('NOW()');
            $currentPrice->save();
        }
    }
    public function getPrice() {
        if (is_null($this->_price)) {
            $storeSetPrice = $this->getCurrentPrice();
            $this->_price = $storeSetPrice ? $storeSetPrice->price : '';
        }
        return $this->_price;
    }
    /**
     * @return StoreSetPrice
     */
    public function getCurrentPrice() {
        return StoreSetPrice::find()
            ->where(['store_set_id' => $this->id, 'status_id' => StoreSetPrice::STATUS_AVAILABLE])
            ->orderBy('id DESC')
            ->one();
    }
}
