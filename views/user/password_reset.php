<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ResetPasswordForm */

$this->title = 'Reset Password';
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><strong><?= Yii::$app->name ?></strong></a>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
        <p class="login-box-msg">Please choose a password</p>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
