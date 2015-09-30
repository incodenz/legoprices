<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ForgotPasswordForm */
/* @var $success bool */

$this->title = 'Forgot Password';
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><strong><?= Yii::$app->name ?></strong></a>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">

                <?php if ($success): ?>
                    <p>A message has been sent to <strong><?= Html::encode($model->email) ?></strong> with detailed instructions on how to proceed with the password reset.</p>

                    <p>Please check your inbox and proceed from there!</p>

                    <p>If the email never arrives, please contact your administrator.</p>
                <?php else: ?>
                    <p>Please enter the email address associated with your account, an email will be sent to that address with further instructions.</p>
                    <?php $form = ActiveForm::begin(['id' => 'forgot-password-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                <?php endif ?>
    </div>
</div>






