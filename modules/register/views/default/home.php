<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */

use yii\helpers\Html;

$this->title = 'CBS 2016 - Registration Complete';

?>
<div class="register complete">

    <h1>Registration Complete</h1>
    <p class="lead">Great! The hard bit is complete. What do you want to do now?</p>

    <div class="row">
        <div class="col-md-4">
            <?= Html::a('Update your registration', ['detail'], ['class' => 'btn btn-sm btn-default']) ?>
        </div>
        <?php if (!$model->isPaid()) { ?>
        <div class="col-md-4">
            <?= Html::a('Pay your registration', ['pay'], ['class' => 'btn btn-sm btn-default']) ?>
        </div>
        <?php } ?>
        <div class="col-md-4">
            <?= Html::a(
                'Attend Events',
                ['events'],
                [
                    'class' => 'btn btn-sm btn-default',

                ]
            ) ?>
            <?php if (!$model->isPaid()) { ?>
                <p class="small">
                    Your registration must be paid for before you can sign up for events during the show.
                </p>
            <?php } ?>
        </div>
    </div>
</div>
