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
<div>
    <?php if (!$model->rrp) { ?>
        <p>Sorry, notifications cannot be sent for this product as no RRP is set</p>
    <?php } else { ?>
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

            <?= Html::submitButton('' .  Yii::t('app', 'Notify Me'), [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-primary btn-sm'
            ]); ?>
            <?php $form->end(); ?>
        <?php } ?>
    <?php } ?>
</div>