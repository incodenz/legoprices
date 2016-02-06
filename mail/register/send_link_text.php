<?php
/* @var \app\modules\register\models\RegistrationTeamMember[] $teamMembers */
/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */

?>

<?php if (count($teamMembers) > 1) { ?>
It looks like you have started several applications, click the link below that you want to edit

<?php foreach($teamMembers as $teamMember) { ?>
<?= $teamMember."\n" ?>
Last Update: <?= Yii::$app->formatter->asDatetime($teamMember->updated_at)."\n" ?>
Status: <?= $teamMember->registration->getStatus()."\n" ?>
<?=  $teamMember->registration->getContinueUrl()."\n" ?>


<?php } ?>
<?php } else { ?>
To continue your registration, follow the link below

<?php foreach($teamMembers as $teamMember) { ?>
<?= $teamMember."\n" ?>
Last Update: <?= Yii::$app->formatter->asDatetime($teamMember->updated_at)."\n" ?>
Status: <?= $teamMember->registration->getStatus()."\n" ?>
<?=  $teamMember->registration->getContinueUrl()."\n" ?>
    <?php } ?>
<?php } ?>


Thanks,
Christchurch Brick Show 2016 Team
