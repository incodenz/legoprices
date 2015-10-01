<?php
use app\models\NotificationAddress;
/* @var NotificationAddress $model */
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */

$url = \yii\helpers\Url::to(['notify/confirm', 'id' => $model->id, 'hash' => $model->hash], 'http');
?>

<p>Before we can send you emails to notify you of prices, you need to confirm your
email address by following the link below</p>

<p><a href="<?= $url ?>"><?=$url ?></a></p>

<p>
Thanks
</p>