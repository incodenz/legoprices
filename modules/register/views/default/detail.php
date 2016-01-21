<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */

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

    <?php
    echo $form->errorSummary(array_merge([$model], $model->registrationTeamMembers)); ?>

    <fieldset>
        <?php if ($model->type_id != Registration::TYPE_VOLUNTEER) { ?>
        <legend>Table Requirements</legend>

            <?= $form->field($model, 'table_size')->dropDownList(array_combine(Registration::getTables(), Registration::getTables())) ?>
            <?= $form->field($model, 'exhibit_details')->textarea() ?>
            <?= $form->field($model, 'power_required')->checkbox() ?>
            <?= $form->field($model, 'travel_grant')->textarea() ?>


            <?= $form->field($model, 'collab_city')->checkbox() ?>
            <?= $form->field($model, 'collab_moonbase')->checkbox() ?>
            <?= $form->field($model, 'collab_gbc')->checkbox() ?>
            <?= $form->field($model, 'collab_glowindark')->checkbox() ?>
        <?php } ?>
        <?= $form->field($model, 'terms')->checkbox()->label('I agree to the terms and conditions') ?>
    </fieldset>

    <?php foreach($model->registrationTeamMembers as $k => $registrationTeamMember) { ?>
    <fieldset>
        <legend>
            <?= count($model->registrationTeamMembers) == 1 ? 'Your Details' : 'Team Member #'.($k + 1) ?>
            <?= $registrationTeamMember->primary_contact ? '' : Html::submitButton(
                'Delete Team Member',
                [
                    'class' => 'btn btn-link btn-xs pull-right',
                    'name' => 'removeMember',
                    'value' => $registrationTeamMember->id
                ]
            ) ?>
        </legend>
        <!-- <p>If you enter a email address we'll send them an email with a link to confirm their details</p> -->
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']first_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']last_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']email')->textInput() ?>

        <?php if (!$registrationTeamMember->primary_contact) { ?>
            <!-- <?= $form
                ->field($registrationTeamMember, '['.$registrationTeamMember->id.']email_me')
                ->checkbox(['class' => 'hide-extra'])
                ->label('Email this Team Member so they can fill in their own details')
            ?> -->

        <div class="extra-fields">
        <?php } ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']contact_number')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']address')->textarea() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']over_18')->checkbox(['class' => 'over18-check']) ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']parental_consent', ['options' => ['class' => 'form-group over18-not']])->checkbox()->label('Parental consent given') ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']option_dinner')->checkbox() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']option_afol', ['options' => ['class' => 'form-group over18-only']])->checkbox(['class' => 'dinner-check']) ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']emergency_contact')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']dietary_requirements', ['options' => ['class' => 'form-group dinner-only']])->textInput() ?>

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
        <?php if (!$registrationTeamMember->primary_contact) { ?>
        </div> <!-- // .hide-extra -->
        <?php } ?>
    </fieldset>
    <?php } ?>
    <hr />
    <div class="pull-left">
        <?= Html::submitButton(
            'Add New Team Member',
            [
                'class' => 'btn btn-default btn-xs',
                'name' => 'addMember',
                'value' => 'addMember'
            ]
        ) ?>
        <p class="small">Registration costs <?= Registration::FEE ?> per person</p>
    </div>
    <div class="pull-right">
        <?= Html::submitButton('Save', [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-primary'
        ]); ?>
    </div>
    <?php ActiveForm::end() ?>


</div>
<?php

$js = <<<JS
$('.over18-check').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.over18-only').show();
        $(this).parents('fieldset').find('.over18-not').hide();
    } else {
        $(this).parents('fieldset').find('.over18-only').hide();
        $(this).parents('fieldset').find('.over18-not').show();
    }
}).change();
$('.dinner-check').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.dinner-only').show();
        $(this).parents('fieldset').find('.dinner-not').hide();
    } else {
        $(this).parents('fieldset').find('.dinner-only').hide();
        $(this).parents('fieldset').find('.dinner-not').show();
    }
}).change();
$('.hide-extra').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.extra-fields').slideUp();
    } else {
        $(this).parents('fieldset').find('.extra-fields').slideDown();
    }
}).change()

JS;

$this->registerJs($js);