<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "store_set".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $legoset_id
 * @property string $url
 *
 * @property \app\models\LegoSet $legoset
 * @property \app\models\Store $store
 * @property \app\models\StoreSetPrice[] $storeSetPrices
 */
class StoreSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store_set';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Store Set} other{Store Sets}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'legoset_id'], 'required'],
            [['store_id', 'legoset_id'], 'integer'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'legoset_id' => 'Legoset ID',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegoset()
    {
        return $this->hasOne(\app\models\LegoSet::className(), ['id' => 'legoset_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(\app\models\Store::className(), ['id' => 'store_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreSetPrices()
    {
        return $this->hasMany(\app\models\StoreSetPrice::className(), ['store_set_id' => 'id']);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = null)
    {
        $query = self::find();

        if ($params === null) {
            $params = Yii::$app->request->get($this->formName(), array());
        }

        $this->load($params, $this->formName());

        $query->andFilterWhere([
            'id' => $this->id,
            'store_id' => $this->store_id,
            'legoset_id' => $this->legoset_id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

