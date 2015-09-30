<?php

namespace app\controllers;

use app\models\LegoSet;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Class SetController
 * @package app\controllers
 */
class SetController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'blank';

    /**
     * @throws HttpException
     */
    public function actionView($code)
    {
        $legoSet = LegoSet::findSet($code);
        if (!$legoSet) {
            throw new NotFoundHttpException;
        }
        return $this->render(
            'view',
            ['model' => $legoSet]
        );
    }
}
