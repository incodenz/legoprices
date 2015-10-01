<?php
use app\models\NotificationAddress;
/* @var NotificationAddress $model */
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */

?>

Before we can send you emails to notify you of prices, you need to confirm your
email address by following the link below

<?= \yii\helpers\Url::to(['notify/confirm', 'id' => $model->id, 'hash' => $model->hash], 'http') ?>


Thanks
