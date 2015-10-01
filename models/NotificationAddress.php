<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "notification_address".
 */
class NotificationAddress extends \app\models\base\NotificationAddress
{
    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['email', 'email'];
        return $rules;
    }
    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = new Expression('NOW()');
        }
        if (!$this->status_id) {
            $this->status_id = self::STATUS_PENDING;
        }
        if (!$this->hash) {
            $this->hash = Yii::$app->security->generateRandomString(5);
        }
        $this->updated_at = new Expression('NOW()');
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert && $this->status_id == self::STATUS_PENDING) {
            $this->sendConfirmationEmail();
        }
    }

    private function sendConfirmationEmail()
    {
        Yii::$app->mailer->compose([
            'html' => 'notify/confirm_email_html',
            'text' => 'notify/confirm_email_text',
            ],
            ['model' => $this]
        )
            ->setFrom(Yii::$app->params['fromEmail'])
            ->setTo($this->email)
            ->setSubject('Please confirm your email address')
            ->send();
    }

}
