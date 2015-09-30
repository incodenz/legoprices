<?php
/**
 * lego - Created by brucealdridge at 30/09/15 13:53
 */

namespace app\models;


use Yii;
use yii\data\ActiveDataProvider;

class LegoSetSearch extends LegoSet
{
    public $price;

    /**
     * @param null $params
     * @return ActiveDataProvider
     */
    public function search($params = null)
    {
        $query = self::find();

        if ($params === null) {
            $params = Yii::$app->request->get($this->formName(), array());
        }

        $this->load($params, $this->formName());

        $query->select(
            [
                self::tableName().'.id id',
                self::tableName().'.title title',
                self::tableName().'.code code',
                self::tableName().'.theme_id theme_id',
                self::tableName().'.rrp rrp',
                'min(price) price',
            ]
        );
        $query->addSelect('');
        $query->innerJoin(StoreSet::tableName(), self::tableName().'.id='.StoreSet::tableName().'.legoset_id');
        $query->innerJoin(StoreSetPrice::tableName(), StoreSet::tableName().'.id='.StoreSetPrice::tableName().'.store_set_id');
        $query->andWhere([StoreSetPrice::tableName().'.status_id' => StoreSetPrice::STATUS_AVAILABLE]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'theme_id', $this->theme_id])
            ;
        $query->groupBy(self::tableName().'.id');

        return new ActiveDataProvider([
            'query' => $query,
            //'sort' => ['defaultOrder' => ['price' => SORT_DESC]],
        ]);
    }
}