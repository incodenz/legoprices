<?php

namespace app\controllers;

use app\models\LegoSetSearch;
use Yii;
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
}
