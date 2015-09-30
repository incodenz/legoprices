<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
?>

Hi <?= $user->__toString() ?>,
<br>
<br>
You recently requested a password reset for your <?=Yii::$app->name ?> account. To complete the process, click the link below.
<br>
<?= Html::a('Reset Password', Url::toRoute(['user/reset-password', 't' => $user->password_reset_token], true)) ?>
<br><br>
This link will expire one hour after this email was sent.
<br><br>
If you didn't make this request, it's likely that another user has entered your email address by mistake and your account is still secure.
If you believe an unauthorized person has accessed your account, you can request a password change at
<?= Html::a('Request a Password Change', Url::toRoute(['user/forgot-password'], true)) ?>
<br>
