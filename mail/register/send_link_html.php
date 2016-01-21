<?php
use app\models\NotificationAddress;
use yii\helpers\Html;

/* @var \app\modules\register\models\RegistrationTeamMember[] $teamMembers */
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */


?>

<?php if (count($teamMembers) > 1) { ?>
    <p>It looks like you have started several applications, click the link below that you want to edit</p><br>
    <?php foreach($teamMembers as $teamMember) { ?>
        <?=$teamMember ?><br>
        Last Update: <?= Yii::$app->formatter->asDatetime($teamMember->updated_at) ?><br>
        Status: <?= $teamMember->registration->getStatus() ?><br>
        <?= Html::a(
            $teamMember->registration->getContinueUrl(),
            $teamMember->registration->getContinueUrl()
        )
        ?><br />
    <?php } ?>
<?php } else { ?>
    <p>To continue your registration, follow the link below</p><br />
    <?php foreach($teamMembers as $teamMember) { ?>
        <?=$teamMember ?><br>
        Last Update: <?= Yii::$app->formatter->asDatetime($teamMember->updated_at) ?><br>
        Status: <?= $teamMember->registration->getStatus() ?><br>
        <?= Html::a(
            $teamMember->registration->getContinueUrl(),
            $teamMember->registration->getContinueUrl()
        )
        ?><br />
    <?php } ?>
<?php } ?>

<p>
Thanks,<br />
    Christchurch Brick Show 2016 Team
</p>