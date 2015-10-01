<?php

/* @var LegoSet $model */
/* @var NotificationAddress $notifyAddress */
/* @var NotificationSet $notifySet */
/* @var bool $notifySuccess */

use app\models\LegoSet;
use app\models\NotificationAddress;
use app\models\NotificationSet;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
<div class="well col-md-6 col-md-offset-3">
    <?php if ($notifySuccess) {
        ?><p>Thanks, we will let you know if the price goes under <?=$notifySet->percent_off?>%</p><?php
    } else { ?>
        <?php $form = ActiveForm::begin([
                'id'     => 'notify',
                'enableClientValidation' => false,
            ]
        ); ?>
        <?php echo $form->errorSummary([$notifyAddress, $notifySet]); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($notifyAddress, 'email')->textInput(['maxlength' => 90])->label('Email me') ?>

            </div>
            <div class="col-md-6">

                <?= $form->field($notifySet, 'percent_off', [
                    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>',
                ])->label('if discount is at least') ?>
            </div>
        </div>
        <?= Html::activeHiddenInput($notifySet, 'set_code') ?>

        <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' .  Yii::t('app', 'Notify Me'), [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-primary'
        ]); ?>
        <?php $form->end(); ?>
    <?php } ?>
</div>
</div>