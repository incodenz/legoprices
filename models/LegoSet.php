<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lego_set".
 *
 * @property string $priceRange
 */
class LegoSet extends \app\models\base\LegoSet
{
    public function __toString()
    {
        return $this->code.' '.($this->theme_id ? $this->theme.' - ' : '').$this->title;
    }

    /**
     * @param $code
     * @return LegoSet|null
     */
    public static function findSet($code) {
        return self::find()->where(['code' => $code])->one();
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['code'] = 'Set #';

        return $labels;
    }


    public function getPriceRange() {
        $prices = [];
        foreach($this->storeSets as $storeSet) {
            $price = $storeSet->price;
            if ($price && $storeSet->currentPrice->status_id == StoreSetPrice::STATUS_AVAILABLE) {
                $prices[] = $price;
            }
        }
        $prices = array_unique($prices);
        if (count($prices) == 0) {
            return '';
        } elseif (count($prices) == 1) {
            return Yii::$app->formatter->asCurrency($prices[0]);
        } else {
            return Yii::$app->formatter->asCurrency(min($prices)) .' - '. Yii::$app->formatter->asCurrency(max($prices));
        }
    }
}
