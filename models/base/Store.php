<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "store".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $hash
 *
 * @property \app\models\StoreSet[] $storeSets
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Store} other{Stores}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->title;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'hash'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 60],
            [['hash'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'hash' => 'Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreSets()
    {
        return $this->hasMany(\app\models\StoreSet::className(), ['store_id' => 'id']);
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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'hash', $this->hash]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

