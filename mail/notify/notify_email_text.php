<?php
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var app\models\NotificationSet $notifySet */
/* @var app\models\LegoSet $model */
/* @var app\models\Store $store */
/* @var app\models\StoreSet $storeSet */
/* @var app\models\StoreSetPrice $storeSetPrice */
?>

Hi,

You asked us to notify you when <?= $model ?> was on sale, well today is
your lucky day.

It just showed up at <?= $store ?> for <?= Yii::$app->formatter->asCurrency($storeSet->price) ?>

Just visit this page for more details <?= \yii\helpers\Url::to(['set/view', 'code' => $model->code], 'http') ?>

