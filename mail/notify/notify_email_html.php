<?php
use app\models\NotificationAddress;
use yii\helpers\Html;

/* @var NotificationAddress $model */
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */

?>
Hi,<br />

<p>You asked us to notify you when <strong><?= $model ?></strong> was on sale, well today is
your lucky day.</p>

<p>
It just showed up at <?= $store ?> for <?= Yii::$app->formatter->asCurrency($storeSet->price) ?>
</p>

<p>Just click the link for more details...
    <?= Html::a($model, \yii\helpers\Url::to(['set/view', 'code' => $model->code], 'http')) ?>
</p>
