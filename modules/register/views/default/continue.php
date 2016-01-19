<?php
/* @var $this \yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'CBS 2016 - Continue Registration';

?>

<h1><?= $this->title ?></h1>

<p class="lead">
    To continue your registration - enter the email address, and we'll send you a link to continue.
</p>


<p>
    If you have started a previous 2016 registration, you can continue it below by entering your email address.
    We will send you an email containing a unique link to access your previous registration.
</p>

<div class="">
    <?php $form = ActiveForm::begin([
            'id'     => 'Team',
            'layout' => 'horizontal',
            'enableClientValidation' => false,
        ]
    ); ?>
    <div class="row">
        <div class="col-xs-8">

            <?= Html::textInput('email', '', ['class' => 'form-control', 'placeholder' => 'Email Address']) ?>
        </div>
        <div class="col-xs-4">
    <?= Html::submitButton('Send Registration Link', [
        'id' => 'send-link' ,
        'class' => 'btn btn-primary btn-sm'
    ]); ?>

        </div>
    </div>
</div>
