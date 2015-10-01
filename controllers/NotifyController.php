<?php

namespace app\controllers;

use app\models\LegoSet;
use app\models\NotificationAddress;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Class NotifyController
 * @package app\controllers
 */
class NotifyController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'blank';

    /**
     * @throws HttpException
     */
    public function actionConfirm($id, $hash)
    {
        /* @var NotificationAddress $notificationAddress */
        $notificationAddress = NotificationAddress::findOne($id);
        if (!$notificationAddress || $notificationAddress->hash != $hash) {
            throw new NotFoundHttpException;
        }
        $notificationAddress->status_id = NotificationAddress::STATUS_CONFIRMED;
        $notificationAddress->save();
        return $this->render(
            'confirm',
            ['model' => $notificationAddress]
        );
    }
}
