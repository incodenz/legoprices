<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */
/* @var $primaryContact app\modules\register\models\RegistrationTeamMember */

use app\modules\register\models\Registration;use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'CBS 2016 - Registration';

?>
<div class="register register-detail">

    <?php $form = ActiveForm::begin([
            'id'     => 'Team',
            'layout' => 'horizontal',
            'enableClientValidation' => false,
        ]
    ); ?>

    <?php echo $form->errorSummary([$model, $primaryContact]); ?>

    <fieldset>
        <legend>Table Requirements</legend>

        <?= $form->field($model, 'table_size')->dropDownList(array_combine(Registration::getTables(), Registration::getTables())) ?>
        <?= $form->field($model, 'power_required')->checkbox() ?>
        <?= $form->field($model, 'travel_grant')->textarea() ?>
        <?= $form->field($model, 'terms')->checkbox()->label('I agree to the terms and conditions') ?>
    </fieldset>

    <?php foreach($model->registrationTeamMembers as $k => $registrationTeamMember) { ?>
    <fieldset>
        <legend><?= 'Team Member #'.($k + 1) ?></legend>
        <p>If you enter a email address we'll send them an email with a link to confirm their details</p>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']first_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']last_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']email')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']contact_number')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']address')->textarea() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']option_dinner')->checkbox() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']option_afol')->checkbox() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']over_18')->checkbox() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']emergency_contact')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']dietary_requirements')->textInput() ?>

        <?= $form
            ->field($registrationTeamMember, '['.$registrationTeamMember->id.']tshirt_size')
            ->dropDownList(
                \app\modules\register\models\RegistrationTeamMember::shirtSizes(),
                [
                    'prompt' => '',
                ]
            ) ?>
        <?= $form
            ->field($registrationTeamMember, '['.$registrationTeamMember->id.']tshirt_colour')
            ->dropDownList(
                \app\modules\register\models\RegistrationTeamMember::shirtColours(),
                [
                    'prompt' => '',
                ]
            ) ?>
    </fieldset>
    <?php } ?>

    <?php ActiveForm::end() ?>


</div>
