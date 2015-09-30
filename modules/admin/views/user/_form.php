<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;
use \dmstr\bootstrap\Tabs;
use webtoolsnz\widgets\RadioButtonGroup;

/**
 * @var yii\web\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
            'id'     => 'User',
            'layout' => 'horizontal',
            'enableClientValidation' => false,
        ]
    ); ?>

    <div class="">
        <?php echo $form->errorSummary($model); ?>
            <p>
            <?= $form->field($model, 'first_name')->textInput() ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => 90]) ?>
            <?= $form->field($model, 'mobile_number')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'role_id')->dropDownList(User::getRoles()) ?>

            <?= $form->field($model, 'status_id')->widget(RadioButtonGroup::className(), [
                'items' => User::getStatuses(),
                'itemOptions' => [
                    'buttons' => [
                        User::STATUS_DELETED => ['activeState' => 'btn active btn-danger'],
                    ]
                ]
            ]); ?>
            </p>

        <hr/>

        <?= Html::submitButton('<span class="fa fa-check"></span> ' . ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')), [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-primary'
        ]); ?>

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Cancel'), \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
        </p>

        <?php ActiveForm::end(); ?>

    </div>

</div>
