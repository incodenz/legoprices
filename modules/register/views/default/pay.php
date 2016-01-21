<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */

use yii\helpers\Html;

$this->title = 'CBS 2016 - Pay Registration';

?>
<div class="register complete">

    <h1>Pay Registration</h1>
    <p class="lead">How would you like to pay?</p>

    <div class="row">
       <div class="col-md-6">
           <h3>POLi</h3>
           <p>
               POLi allows for instantaneous transfer between your bank account and ours.
               We can confirm payment immediately and allow you to sign up to some of our <?= Html::a('events', ['events']) ?>
           </p>
       </div>
       <div class="col-md-6">
           <h3>Bank Transfer</h3>
           <p>
               With bank transfers we will update your payment details in the system every few days.
               Once your payment is confirmed you will get an email then you can signup to some of our <?= Html::a('events', ['events']) ?> running during the show
           </p>
       </div>
    </div>
</div>
