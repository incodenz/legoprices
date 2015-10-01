<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "notification_set".
 */
class NotificationSet extends \app\models\base\NotificationSet
{
    const STATUS_PENDING = 1;
    const STATUS_SENT = 2;

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = new Expression('NOW()');
        }
        if ($this->status_id == self::STATUS_SENT && !$this->sent_at) {
            $this->sent_at = new Expression('NOW()');
        }
        if (!$this->hash) {
            $this->hash = Yii::$app->security->generateRandomString(5);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @param StoreSetPrice $storeSetPrice
     */
    public function notify($storeSetPrice)
    {
        if ($this->notificationAddress->status_id != NotificationAddress::STATUS_CONFIRMED) {
            // sorry email not confirmed - you miss you
            return ;
        }

        $storeSet = $storeSetPrice->storeSet;
        $store = $storeSet->store;
        $model = $storeSet->legoset;
        $subject = 'Lego Set: '.$model.' on sale at '.$store->title;

        Yii::$app->mailer->compose(
            [
                'html' => 'notify/notify_email_html',
                'text' => 'notify/notify_email_text',
                ],
                [
                    'notifySet' => $this,
                    'model' => $model,
                    'store' => $store,
                    'storeSet' => $storeSet,
                    'storeSetPrice' => $storeSetPrice,
                ]
            )
            ->setFrom(Yii::$app->params['fromEmail'])
            ->setTo($this->notificationAddress->email)
            ->setSubject($subject)
            ->send();
    }

}
