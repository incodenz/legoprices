<?php

namespace app\controllers;

use app\models\LegoSetSearch;
use app\models\StoreSetPrice;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use app\models\User;
use yii\web\HttpException;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'blank';

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    /**
     * @throws HttpException
     */
    public function actionIndex()
    {
        $searchModel  = new LegoSetSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTop() {

        $query = new Query();
        $query->select = [
            'code',
            'min(store_set_price.price) AS price',
            'rrp',
            '(rrp-min(store_set_price.price)) / rrp * 100 AS discount',
            'rrp - min(store_set_price.price) discount_price'
        ];
        $query->from = ['lego_set'];
        $query->join = [
            ['INNER JOIN', 'store_set', 'lego_set.id = store_set.legoset_id'],
            ['INNER JOIN', 'store_set_price', 'store_set.id = store_set_price.store_set_id'],
        ];
        $query->where = 'store_set_price.status_id!='.StoreSetPrice::STATUS_EXPIRED;
        $query->groupBy = ['lego_set.id'];
        //$query->orderBy('discount desc');
        $query->limit = 100;

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
        ]);
        $provider->sort->attributes['discount'] = [
            'asc' => ['discount_price' => SORT_DESC],
            'desc' => ['discount' => SORT_DESC],
        ];
        $provider->sort->attributes['discount_price'] = [
            'asc' => ['discount' => SORT_DESC],
            'desc' => ['discount_price' => SORT_DESC],
        ];

        return $this->render(
            'top',
            [
                'provider' => $provider
            ]
        );
    }
}
