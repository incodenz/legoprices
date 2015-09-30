<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "store_set_price".
 *
 * @property integer $id
 * @property integer $store_set_id
 * @property string $price
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status_id
 *
 * @property \app\models\StoreSet $storeSet
 */
class StoreSetPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store_set_price';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Store Set Price} other{Store Set Prices}}', ['n' => $n]);
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
            [['store_set_id', 'price', 'status_id'], 'required'],
            [['store_set_id', 'status_id'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_set_id' => 'Store Set ID',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreSet()
    {
        return $this->hasOne(\app\models\StoreSet::className(), ['id' => 'store_set_id']);
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
            'store_set_id' => $this->store_set_id,
            'price' => $this->price,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

