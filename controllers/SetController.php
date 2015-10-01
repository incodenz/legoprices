<?php

namespace app\controllers;

use app\models\LegoSet;
use app\models\NotificationAddress;
use app\models\NotificationSet;
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

        $notifySet = new NotificationSet();
        $notifyAddress = new NotificationAddress();
        $notifyAddress->email = Yii::$app->session->get('notify.email', '');
        $notifySet->percent_off = Yii::$app->session->get('notify.percent', 20);;

        $notifySet->load(Yii::$app->request->post());
        $notifyAddress->load(Yii::$app->request->post());
        if ($notifyAddress->email) {
            $nA = NotificationAddress::find()->where(['email' => $notifyAddress->email])->one();
            if ($nA) {
                $notifyAddress = $nA;
            }
        }
        $notifySet->set_code = $legoSet->code;
        $success = false;
        if (Yii::$app->request->isPost) {
            $success = $notifyAddress->validate(['email']);
            $success = $notifySet->validate(['percentage_off']) && $success;
            $notifySet->status_id = NotificationSet::STATUS_PENDING;
            if ($success) {
                if ($notifyAddress->isNewRecord) {
                    $notifyAddress->status_id = NotificationAddress::STATUS_PENDING;
                    $success = $notifyAddress->save();
                }
                $notifySet->notification_address_id = $notifyAddress->id;
                if ($success) {
                    Yii::$app->session->set('notify.email', $notifyAddress->email);
                    Yii::$app->session->set('notify.percent', $notifySet->percent_off);
                    $success = $notifySet->save();
                }
            }
        }


        return $this->render(
            'view',
            [
                'model' => $legoSet,
                'notifySet' => $notifySet,
                'notifyAddress' => $notifyAddress,
                'notifySuccess' => $success
            ]
        );
    }
}
